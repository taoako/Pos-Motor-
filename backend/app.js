const express = require('express');
const app = express();
const port = 3000;

const customerRoutes = require('./routes/customers');

app.use(express.json());
app.use(customerRoutes);

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});