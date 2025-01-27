const mysql = require('mysql');

const connection = mysql.createConnection({
  host: 'localhost', // Ensure this is correct
  user: 'yourUsername', // Ensure this is correct
  password: 'yourPassword', // Ensure this is correct
  database: 'yourDatabaseName' // Ensure this is correct
});

connection.connect((err) => {
  if (err) {
    console.error('Error connecting to the database:', err.stack);
    return;
  }
  console.log('Connected to the database as id ' + connection.threadId);
});

module.exports = connection;
