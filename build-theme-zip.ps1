$ErrorActionPreference = 'Stop'

$themeSlug = 'holt-holdings'
$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$zipPath = Join-Path $root "$themeSlug.zip"
$excludeTopLevel = @(
  '.git',
  '.github',
  'holt-holdings',
  'legacy-static-site',
  'original',
  'Hands-On-Idaho'
)
$excludeFiles = @(
  '.gitattributes',
  '.gitignore',
  'build-theme-zip.ps1',
  "$themeSlug.zip"
)

if (Test-Path -LiteralPath $zipPath) {
  Remove-Item -LiteralPath $zipPath -Force
}

Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$zip = [System.IO.Compression.ZipFile]::Open($zipPath, [System.IO.Compression.ZipArchiveMode]::Create)
try {
  Get-ChildItem -LiteralPath $root -Recurse -File | ForEach-Object {
    $relative = $_.FullName.Substring($root.Length + 1)
    $parts = $relative -split '[\\/]'

    if ($excludeTopLevel -contains $parts[0]) {
      return
    }

    if ($excludeFiles -contains $relative) {
      return
    }

    $entryName = "$themeSlug/" + $relative.Replace('\', '/')
    [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile(
      $zip,
      $_.FullName,
      $entryName,
      [System.IO.Compression.CompressionLevel]::Optimal
    ) | Out-Null
  }
}
finally {
  $zip.Dispose()
}

Write-Host "Created $zipPath"
