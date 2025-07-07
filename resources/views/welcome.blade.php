<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Subscribe Example</title>
</head>
<body>

  <h1>Test Subscribe</h1>
  <button id="subscribe-btn">Subscribe Now</button>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
document.getElementById('subscribe-btn').addEventListener('click', () => {
    axios.post("{{ config('app.url') }}api/subscriber", {
    emailAddress: 'test100@gmail.com',
        firstName: 'Test',
        lastName: 'Last',
        dateOfBirth: '1995-05-05',
        marketingConsent: true,
        lists: ["01JZJ0EYT9XFCFT6WPFC4FNCR0", "01JZJ0EYT9XFCFT6WPFC4FNCR1"],
        message: 'I like to get more information'
    })
    .then(res => {
    console.log(res.data);
    
    })
    .catch(err => {
    console.error(err.response?.data || err.message);
    });

});
 </script>
 
</body>
</html>
 
