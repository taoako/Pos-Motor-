const express = require('express');
const router = express.Router();
const db = require('../db'); // Adjust path to your database connection

router.post('/api/customers', async (req, res) => {
    const { name, email, phone } = req.body;

    if (!name || !email || !phone) {
        return res.status(400).json({ error: 'All fields are required.' });
    }

    try {
        await db.query('INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)', [name, email, phone]);
        res.status(201).json({ message: 'Customer saved successfully.' });
    } catch (error) {
        console.error('Database error:', error);
        res.status(500).json({ error: 'Failed to save customer.' });
    }
});

module.exports = router;
