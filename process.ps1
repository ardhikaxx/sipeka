$status = git status --porcelain
foreach($line in $status){
    $st = $line.Substring(0,2)
    $file = $line.Substring(3).Trim()
    if($file -eq '') { continue }
    if($file -like '*\/' -or (Test-Path -LiteralPath $file -PathType Container)) { continue }
    if($st -like '*?*') {
        $msg = 'feat: penambahan fitur ' + $file
        Write-Host 'Processing new file:' $file
        git add "`"$file`""
        git commit -m $msg
        git push origin HEAD
    } elseif($st -like '*M*') {
        $msg = 'fix: perbaikan pada ' + $file
        Write-Host 'Processing modified file:' $file
        git add "`"$file`""
        git commit -m $msg
        git push origin HEAD
    }
}