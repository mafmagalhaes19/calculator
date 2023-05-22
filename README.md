# Calculator
The aim of this project is to build a calculator that performs the basic operations.


# How to run it

1. Create the database.
```
cd database
sqlite3 database.db < database.sql
cd ..
```
2. Run php server.
```
php -S localhost:8000
```
3. Open http://localhost:8000/ and use the calculator.

# How to access the data in the database
```
cd database
sqlite3 database.db
```
Inside the sqlite terminal, run the following query in order to get all the data from the database:
```
SELECT * FROM Calculator;
```

# Notes
- The calculator can evaluate expressions with parentheses and it takes into account the following rules:
    - The first parantheses must have an operator on its left and a number on its right.
        - Example:
        ```
        (1+2) = 3 => VALID
        2*(3+1) = 8 => VALID
        1+(MOD1) => ERROR
        1(2+3) => ERROR
        ```
    - The second parantheses must have a number on its left and an operator on its right.
         - Example:
        ```
        (1+2) = 3 => VALID
        (3+1)*3 = 12 => VALID
        1+(1*)2 => ERROR
        (2+3)4 => ERROR
        ```
- The error messages are always the same on the calculator screen (`ERROR`), but if you open the developer tools, you can see the specific error message on the logs of the console.
- It is also possible to see on these logs the input values given by the user, the result of the operation, the random number generated for each operation and the result of the bonus (true if the result is equal to the random number and false otherwise).