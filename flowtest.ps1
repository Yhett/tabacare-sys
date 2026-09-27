$ErrorActionPreference = 'Stop'
$base = 'http://127.0.0.1:8000'

function Token($html) {
    if ($html -and $html -match 'name="_token"\s+value="([^"]+)"') { return $Matches[1] }
    return $null
}

function Show-Ex($where, $err) {
    Write-Output "$where EXCEPTION type=$($err.Exception.GetType().FullName) msg=$($err.Exception.Message)"
    $resp = $err.Exception.Response
    if ($resp -is [System.Net.HttpWebResponse]) {
        Write-Output "$where EXSTATUS=$([int]$resp.StatusCode)"
        try {
            $sr = New-Object System.IO.StreamReader($resp.GetResponseStream())
            $body = $sr.ReadToEnd()
            Write-Output "$where EXBODY=$($body.Substring(0, [Math]::Min(500, $body.Length)) -replace '\s+', ' ')"
        } catch { Write-Output "$where EXBODY unreadable" }
    }
}

# 1. Home page: session + CSRF token
try {
    $homeResp = Invoke-WebRequest "$base/" -UseBasicParsing -SessionVariable 'S'
    $t = Token $homeResp.Content
    Write-Output "HOME status=$($homeResp.StatusCode) token=$([bool]$t)"
} catch {
    Show-Ex 'HOME' $_
    exit 1
}

# 2. Login as test health worker (follow redirects)
$loginBody = "_token=$t&username=apitest&password=secret123&role=health_worker&barangay=Visita"
try {
    $login = Invoke-WebRequest "$base/login" -UseBasicParsing -WebSession $S -Method Post -Body $loginBody
    Write-Output "LOGIN status=$($login.StatusCode) url=$($login.BaseResponse.ResponseUri.AbsoluteUri)"
} catch {
    Show-Ex 'LOGIN' $_
}

# 3. Reports create page (fresh token)
try {
    $create = Invoke-WebRequest "$base/reports/create" -UseBasicParsing -WebSession $S
    $t2 = Token $create.Content
    Write-Output "CREATE status=$($create.StatusCode) token=$([bool]$t2) isCreate=$($create.Content -match 'Generate barangay report')"
} catch {
    Show-Ex 'CREATE' $_
    exit 1
}

# 4. Generate preview
$genBody = "_token=$t2&prepared_by=API+Test&period_type=monthly&month=$((Get-Date).Month)"
try {
    $gen = Invoke-WebRequest "$base/reports/generate" -UseBasicParsing -WebSession $S -Method Post -Body $genBody
    Write-Output "GENERATE status=$($gen.StatusCode) ok=$($gen.Content -match 'report generated successfully')"
} catch {
    Show-Ex 'GENERATE' $_
}

# 5. Download exactly like the submit-guard fetch() does
$dlBody = "_token=$t2&prepared_by=API+Test&period_type=monthly&month=$((Get-Date).Month)"
try {
    $dl = Invoke-WebRequest "$base/reports/download" -UseBasicParsing -WebSession $S -Method Post -Body $dlBody `
        -Headers @{ 'X-Requested-With' = 'XMLHttpRequest'; 'X-CSRF-TOKEN' = $t2 } -MaximumRedirection 0
    Write-Output "DOWNLOAD status=$($dl.StatusCode)"
    Write-Output "DOWNLOAD ctype=$($dl.Headers['Content-Type'])"
    Write-Output "DOWNLOAD disposition=$($dl.Headers['Content-Disposition'])"
    Write-Output "DOWNLOAD bytes=$($dl.RawContentLength)"
    $head = $dl.Content.Substring(0, [Math]::Min(300, $dl.Content.Length))
    Write-Output "DOWNLOAD head=$($head -replace '\s+', ' ')"
} catch {
    Show-Ex 'DOWNLOAD' $_
}
