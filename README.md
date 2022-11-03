# NFT Data Formater (CHIP-0007)

## How to use
1. Prepare the CSV
   Create six columns with the appropriate data: 
   - Column1 => Series Number (also for the team names in an empty row)
   - Column2 => Filename (not in use currently)
   - Column3 => Name (NFT name)
   - Column4 => Description
   - Column5 => Gender
   - Column6 => Attributes (contains colon-separated key and value pairs, delimited by either a comma or a period. The attributes keys are `hair, eyes, clothing, accessories, expression, strength, weakness, teeth`)
   - Column7 => UUID (not in use currently)
   Note that the Team names ('minting_tool') will occupy an empty row, before the NFTs.
   
2. Open CMD

3. Upload and run script using Curl: `curl -F "csv=@C:/path/to/csv/filename.csv" https://nftdataformatter.herokuapp.com/script.php --ssl-no-revoke`
For example, `curl -F "csv=@C:/Users/HP/Downloads/HNGi9.csv" https://nftdataformatter.herokuapp.com/script.php --ssl-no-revoke`
 
4. Download the 'filename.output.csv' file using Curl: `curl -O https://nftdataformatter.herokuapp.com/output/[filename].output.csv --ssl-no-revoke`
For example, `curl -O https://nftdataformatter.herokuapp.com/output/HNGi9.output.csv --ssl-no-revoke`

### NB
 - Take note of the filename when uploading, it will also be required when downloading.
 - Delimiters for the 'Attributes' column should not be omitted. It currently reads comma (,) and dot (.) as delimiters, then semicolon (;) between each key-value pair.
 - The csv file can also be uploaded from `https://nftdataformatter.herokuapp.com` and the output will be downloaded from terminal.
