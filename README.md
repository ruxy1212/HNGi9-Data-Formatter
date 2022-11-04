# NFT Data Formatter (CHIP-0007)

## Description
This script is a tool which uploads a .csv file containing NFT data to the server and generates a JSON for each entry, and thn appends the hash of each JSON to the output .csv file.

The JSON is generated for every entry using CHIP-0007 schema. An hash (SHA-256) checksum is calculated from the JSON. An output .csv file will be generated after the hash from each JSON is appended to the uploaded .csv file.

## How to use
1. Prepare the CSV
   Create seven columns with the appropriate data: 
   - Column0 => Team names (Minting tool)
   - Column1 => Series Number
   - Column2 => Filename (not in use currently)
   - Column3 => Name (NFT name)
   - Column4 => Description
   - Column5 => Gender
   - Column6 => Attributes (contains colon-separated key and value pairs, delimited by semicolon. The attributes keys are `hair, eyes, clothing, accessories, expression, strength, weakness, teeth`)
   - Column7 => UUID (not in use currently)
   
2. Open Terminal

3. Upload CSV and run script using Curl: `curl -F "csv=@C:/path/to/csv/filename.csv" https://nftdataformatter.herokuapp.com/script.php --ssl-no-revoke`
For example, `curl -F "csv=@C:/Users/HP/Downloads/HNGi9.csv" https://nftdataformatter.herokuapp.com/script.php --ssl-no-revoke`
 
4. Download the 'filename.output.csv' file using Curl: `curl -O https://nftdataformatter.herokuapp.com/output/[filename].output.csv --ssl-no-revoke`
For example, `curl -O https://nftdataformatter.herokuapp.com/output/HNGi9.output.csv --ssl-no-revoke`

## CHIP-0007 Sample JSON Schema
```{
     "format": "CHIP-0007",
     "name": "Pikachu",
     "description": "Electric-type Pokémon with stretchy cheeks",
     "minting_tool": "SuperMinter/2.5.2",
     "sensitive_content": false,
     "series_number": 22,
     "series_total": 1000,
     "attributes": [
         {
             "trait_type": "Species",
             "value": "Mouse"
         },
         {
             "trait_type": "Color",
             "value": "Yellow"
         },
         {
             "trait_type": "Friendship",
             "value": 50,
             "min_value": 0,
             "max_value": 255
         }
     ],
     "collection": {
         "name": "Example Pokémon Collection",
         "id": "e43fcfe6-1d5c-4d6e-82da-5de3aa8b3b57",
         "attributes": [
             {
                 "type": "description",
                 "value": "Example Pokémon Collection is the best Pokémon collection. Get yours today!"
             },
             {
                 "type": "icon",
                 "value": "https://examplepokemoncollection.com/image/icon.png"
             },
             {
                 "type": "banner",
                 "value": "https://examplepokemoncollection.com/image/banner.png"
             },
             {
                 "type": "twitter",
                 "value": "ExamplePokemonCollection"
             },
             {
                 "type": "website",
                 "value": "https://examplepokemoncollection.com/"
             }
         ]
     },
     "data": {
         "example_data": "VGhpcyBpcyBhbiBleGFtcGxlIG9mIGRhdGEgdGhhdCB5b3UgbWlnaHQgd2FudCB0byBzdG9yZSBpbiB0aGUgZGF0YSBvYmplY3QuIE5GVCBhdHRyaWJ1dGVzIHdoaWNoIGFyZSBub3QgaHVtYW4gcmVhZGFibGUgc2hvdWxkIGJlIHBsYWNlZCB3aXRoaW4gdGhpcyBvYmplY3QsIGFuZCB0aGUgYXR0cmlidXRlcyBhcnJheSB1c2VkIG9ubHkgZm9yIGluZm9ybWF0aW9uIHdoaWNoIGlzIGludGVuZGVkIHRvIGJlIHJlYWQgYnkgdGhlIHVzZXIu"
     }
 }
 ```

### Notes
 - Take note of the filename when uploading, it will also be required when downloading.
 - Delimiters for the 'Attributes' column should not be omitted. It currently reads semicolons (;) as delimiters, then colon (:) between each key-value pair.
 - The csv file can also be uploaded from [`https://nftdataformatter.herokuapp.com`](https://nftdataformatter.herokuapp.com) and the output will be downloaded from terminal using cURL [Step 4 above](##How to use). 

## References
- [NFT Naming Requirements](https://docs.google.com/document/d/1Ud5ep77nIoGrqsHM3mX-dEVTEpV_RMPsO9IAXUqBNk0/edit)
- [CHIP-0007 Schema example](https://github.com/Chia-Network/chips/blob/main/assets/chip-0007/example.json)

