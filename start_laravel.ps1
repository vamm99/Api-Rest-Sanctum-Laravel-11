Start-Process -NoNewWindow -FilePath "php" -ArgumentList "artisan serve"
Start-Process -NoNewWindow -FilePath "php" -ArgumentList "artisan queue:listen"
Start-Process -NoNewWindow -FilePath "php" -ArgumentList "artisan reverb:start --debug"
