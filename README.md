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
		<br>

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
		<br>

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
<br>


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
		<br>

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
		<br>

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
		<br>

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
		<br>

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
<br>

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
		<br>

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
<br>


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
		<br>

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
		<br>

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
		<br>

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
		<br>

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
<br>

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
		<br>

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
<br>


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
		<br>

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
		<br>

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
		<br>

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
		<br>

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
		<br>

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
		<br>

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

## Products

- ### Create Product

	- #### REQUEST
		#### Endpoint
			POST /product
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"name":"novo produto",
			"type": "food",
			"volume": 200,
			"unit_mensure": "mg"
		}
		```
		<br>

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

- ### Products List

	- #### REQUEST
		#### Endpoint
			GET /products
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		[
			{
				"id": "1",
				"name":"produto",
				"type": "food",
				"volume": 400,
				"unit_mensure": "mg"
			},
			{
				"id": "2",
				"name":"novo produto",
				"type": "food",
				"volume": 200,
				"unit_mensure": "mg"
			}
		]
		```
--- 
<br>

- ### Product Detail

	- #### REQUEST
		#### Endpoint
			GET /product/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"id": "2",
			"name":"novo produto",
			"type": "food",
			"volume": 200,
			"unit_mensure": "mg"
		}
		```
--- 
<br>


- ### Edit Product

	- #### REQUEST
		#### Endpoint
			PUT /product/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"name":"novo produto",
			"type": "food",
			"volume": 200,
			"unit_mensure": "mg"
		}
		```
		<br>

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


- ### Delete Categories

	- #### REQUEST
		#### Endpoint
			DELETE /product/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

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

## Shopping List

- ### Create Shopping List

	- #### REQUEST
		#### Endpoint
			POST /shopping-list/create
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"name" : "teste", 
			"type" : "food"
		}
		```
		<br>

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

- ### Shopping Lists List

	- #### REQUEST
		#### Endpoint
			GET /shopping-list
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		[
			{
				"id": "1",
				"accounts_id": "2",
				"name": "Dieta ganho",
				"type": "food"
			},
			{
				"id": "2",
				"accounts_id": "2",
				"name": "Dieta perda",
				"type": "food"
			}
		]
		```
--- 
<br>

- ### Shopping List Detail

	- #### REQUEST
		#### Endpoint
			GET /shopping-list/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"id": "1",
			"accounts_id": "2",
			"name": "Dieta 90 kg",
			"type": "food"
		}
		```
--- 
<br>


- ### Edit Shopping List

	- #### REQUEST
		#### Endpoint
			PUT /shopping-list/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"name":"novo produto",
			"type": "food",
		}
		```
		<br>

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


- ### Delete Shopping List

	- #### REQUEST
		#### Endpoint
			DELETE /shopping-list/{id}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

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

## Bond Products Shopping List

- ### Add new product to any shopping list
	- #### REQUEST
		#### Endpoint
			POST /shopping-list/{id}/new-product
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"categories_id" : 46, 
			"products_id" : 2,
			"amount" : 2
		}
		```
		<br>

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

- ### List products from shopping list
	- #### REQUEST
		#### Endpoint
			GET /shopping-list/{id}/products
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		[
			{
				"id": "27",
				"shopping_lists_id": "1",
				"categories_id": "47",
				"products_id": "6",
				"amount": "2"
			},
			{
				"id": "34",
				"shopping_lists_id": "1",
				"categories_id": "47",
				"products_id": "2",
				"amount": "2"
			},
			...
		]
		```
--- 
<br>

- ### Delete bond product from shopping list

	- #### REQUEST
		#### Endpoint
			DELETE /shopping-list/product/bond/{bondId}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

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

## Bond Products Option Shopping List

- ### Add new option to product Shopping list
	- #### REQUEST
		#### Endpoint
			POST /shopping-list/execution/{hash}/{productListId}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		{
			"products_id": 5,
			"brands_id": 47,
			"quantity": 2,
			"type_description": "teste",
			"weight": 1.100,
			"unit_mensure": "g",
			"price": 22.70
		}
		```
		<br>

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

- ### List option from product shopping list
	- #### REQUEST
		#### Endpoint
			GET /shopping-list/execution/{hash}/{productListId}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		[
			{
				"id": "2",
				"shopping_lists_execution_hash": "c4ca4238a0b923820dcc509a6f75849b",
				"bond_shopping_lists_products_id": "27",
				"products_id": "5",
				"brands_id": "47",
				"type_description": "teste",
				"wheight": "2000.10",
				"unit_mensure": "mg",
				"quantity": "2",
				"price": "23.50"
			},
			{
				"id": "3",
				"shopping_lists_execution_hash": "c4ca4238a0b923820dcc509a6f75849b",
				"bond_shopping_lists_products_id": "27",
				"products_id": "5",
				"brands_id": "47",
				"type_description": "teste",
				"wheight": "10000.00",
				"unit_mensure": "mg",
				"quantity": "2",
				"price": "23.50"
			},
			...
		]
		```
--- 
<br>


- ### Detail option from product shopping list
	- #### REQUEST
		#### Endpoint
			GET /shopping-list/execution/{hash}/product/option/{productOptionId}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"OptionId": "10",
			"OptionProductId": "5",
			"OptionProductName": "novo produto",
			"OptionProductBrandName": "Seara"
		}
		```
--- 
<br>


- ### Delete option from product shopping list
	- #### REQUEST
		#### Endpoint
			DELETE /shopping-list/execution/{hash}/product/option/{productOptionId}
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

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

- ### Find best option product shopping list

	- #### REQUEST
		#### Endpoint
			GET /shopping-list/execution/{hash}/{productListId}/best-choice
		#### Headers
			- Access-Token
			- Content-Type
			- Authorization
		#### Body
		```json
		
		```
		<br>

	- #### RESPONSE
		#### Headers
			- Content-Type
		#### Body
		```json
		{
			"id": "6",
			"name": "5",
			"brand_id": "47",
			"price": 23.45,
			"weight": 199999.998
		}
		```
	--- 
	<br>