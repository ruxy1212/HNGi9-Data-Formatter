# NFT Data Formater

## How to use
1. Open CMD

2. Upload and run script using Curl: `curl -F "csv=@C:/path/to/csv/file.csv" https://nftdataformatter.herokuapp.com/script.php --ssl-no-revoke`
For example, `curl -F "csv=@C:/Users/HP/Downloads/HNGi9.csv" https://nftdataformatter.herokuapp.com/script.php --ssl-no-revoke`
 
3. Download the 'filename.output.csv' file using Curl: `curl -O https://nftdataformatter.herokuapp.com/output/HNGi9.output.csv --ssl-no-revoke`
