const ping = require('ping');

module.exports = async (req, res) => {
  try {
    const { ip } = req.query; // Extract IP address from the query parameter
    if (!ip) {
      return res.status(400).json({ error: 'IP parameter is missing.' });
    }

    const result = await ping.promise.probe(ip);
    if (result.alive !== undefined && result.time !== undefined) {
      return res.status(200).json({ ping: result.time });
    } else {
      return res.status(500).json({ error: 'Invalid ping response.' });
    }
  } catch (error) {
    console.error('Error pinging the IP address:', error);
    return res.status(500).json({ error: 'Error pinging the IP address.' });
  }
};
