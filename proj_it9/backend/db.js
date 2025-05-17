const mysql = require('mysql2/promise');

const pool = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: 'password', // Replace with your database password
    database: 'pos_motor', // Replace with your database name
});

module.exports = pool;
