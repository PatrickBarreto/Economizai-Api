# Economizaí API DOC

## Account
- ### Create Account

	- #### REQUEST
		#### Endpoint
			POST /accounts
		#### Headers
			- Access-Token
			- Content-Type
		#### Body
		```json
		{
			"name":"Patrick",
			"phone":22997360453,
			"email":"co2@gmail.com"
		}
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 

- ### Accounts Detail

	- #### REQUEST
		#### Endpoint
			GET /accounts/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"name": "name",
			"phone": "phone",
			"email": "email"
		}
		```
--- 


- ### Edit Account

	- #### REQUEST
		#### Endpoint
			PUT /accounts/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"name":"editado",
			"phone":22997360452,
			"email":"co@gmeail.com"
		}
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 


- ### Delete Account

	- #### REQUEST
		#### Endpoint
			DELETE /accounts/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 
<br>

## Brands

- ### Create Brands

	- #### REQUEST
		#### Endpoint
			POST /brands
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"name":"Seara"
		}
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 

- ### Brands List

	- #### REQUEST
		#### Endpoint
			GET /brands
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			[
				{
					"id": "1",
					"accounts_id": "2",
					"name": "Sadia",
					"type": "food"
				},
				...
			]
		}
		```
--- 

- ### Brands Detail

	- #### REQUEST
		#### Endpoint
			GET /brands/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"id": "1",
			"accounts_id": "2",
			"name": "Sadia",
			"type": "food"
		}
		```
--- 


- ### Edit Brands

	- #### REQUEST
		#### Endpoint
			PUT /brands/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"name":"Sadia"
		}
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 


- ### Delete Brands

	- #### REQUEST
		#### Endpoint
			DELETE /brands/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 


## Categories

- ### Create Categories

	- #### REQUEST
		#### Endpoint
			POST /categories
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"name":"Seara"
		}
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 

- ### Categories List

	- #### REQUEST
		#### Endpoint
			GET /categories
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		[
			{
				"id": "46",
				"accounts_id": "0",
				"name": "Outros",
				"products": [
					{
						"id": "2",
						"name": "Caldo"
					},
					...
				]
			},
			...
		]
		```
--- 

- ### Categories Detail

	- #### REQUEST
		#### Endpoint
			GET /category/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"id": "46",
			"accounts_id": "0",
			"name": "Outros",
			"products": [
					{
						"id": "2",
						"name": "Caldo"
					},
					...
				]
		}
		```
--- 


- ### Edit Categories

	- #### REQUEST
		#### Endpoint
			PUT /category/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"name":"Proteina"
		}
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 


- ### Delete Categories

	- #### REQUEST
		#### Endpoint
			DELETE /category/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 


## Bond Categories Brands

- ### Create new category brand
	- #### REQUEST
		#### Endpoint
			POST /category/{id}/new-brand
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"brands_id":[1, 2, 4]
		}
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 

- ### Delete category brand

	- #### REQUEST
		#### Endpoint
			DELETE /category/{id}/brand
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 



## Bond Categories Products

- ### Create new category product
	- #### REQUEST
		#### Endpoint
			POST /category/{id}/new-product
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"product_id":[1, 2, 4]
		}
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 

- ### Delete category product

	- #### REQUEST
		#### Endpoint
			DELETE /category/{id}/product
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br><br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"success": true
		}
		```
--- 