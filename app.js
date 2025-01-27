const express = require('express');
const app = express();
const db = require('./dbConfig');

// ...existing code...

// Example route to test database connection
app.get('/test-db', (req, res) => {
  db.query('SELECT 1 + 1 AS solution', (err, results) => {
    if (err) {
      res.status(500).send('Database query failed');
      return;
    }
    res.send('Database query succeeded: ' + results[0].solution);
  });
});

// ...existing code...

app.listen(3000, () => {
  console.log('Server is running on port 3000');
});
