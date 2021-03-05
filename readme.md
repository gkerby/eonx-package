## Entities
- CustomerDTO - provides a way for storing intermediate data got from external data source. Later
it can be used to fill entity and store in database

## Responsibilities
Names are provided without `Interface` postfix

- DataProvider - responsible for providing us with an array of CustomerDTO entities 
  got from external data source
- Fetcher - responsible for communicating with external data source
- CustomerDTOFactory - responsible for creating CustomerDTO entity from external customer's data
- FetcherFilter - responsible for managing parameters of filtering in fetchers
- CustomerValidator - responsible for assuring that incoming customer data is valid. 
  It should validate CustomerDTO entity after it is built from external data   
- CustomerStorage - responsible for storing incoming CustomerDTO entities (say in DB) during import
- Importer - responsible for taking customers from external data source in put them into persistent storage

## Dependencies
- DataProvider depends on a fetcher and a customerDTO factory
- Customer factory depends on a customer validator
- Importer depends on ExternalCustomersProvider and CustomerStorage

## Implementing new source of customers
If your have to introduce a new source of customers you have to: 
- implement new ExternalCustomersFetcher since chances are very high that location of API 
  and format of method result has changed
- implement new CustomerAdapterFactory since format of API data has probably changed

Then you have to provide ExternalCustomersProvider with a new fetcher and a factory, 
and in most cases that's pretty much enough

