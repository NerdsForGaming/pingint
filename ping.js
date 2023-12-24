// api/ping.js

const ping = require('ping');

module.exports = async (req, res) => {
  const { ip } = req.query; // Extract IP address from the query parameter
  if (!ip) {
    return res.status(400).json({ error: 'IP parameter is missing.' });
  }

  try {
    const result = await ping.promise.probe(ip);
    return res.status(200).json({ ping: result });
  } catch (error) {
    return res.status(500).json({ error: 'Error pinging the IP address.' });
  }
};
