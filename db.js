const mysql = require('mysql');

const connection = mysql.createConnection({
  host: 'localhost', // Replace with your host
  user: 'your_username', // Replace with your database username
  password: 'your_password', // Replace with your database password
  database: 'your_database' // Replace with your database name
});

connection.connect((err) => {
  if (err) {
    console.error('Error connecting to the database:', err.stack);
    return;
  }
  console.log('Connected to the database as id', connection.threadId);
});

module.exports = connection;
