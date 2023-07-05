<h1 align="center">Dots Test Telegram Bot</h1>
<p align="center">The bot provides a food ordering service</p>
<h2>Functionality provided by the bot:</h2>
<ul>
  <li>Ability to choose the city in which the user wants to place an order</li>
  <li>Possibility to choose the company in which the user wants to place an order</li>
  <li>Forming a basket, that is, the user can choose the dishes he wants to order. The customer can choose dishes to order from only one company. If he tries to add dishes to the cart, but there are already dishes from another company in the cart, the bot will inform the user about this.</li>
  <li>Order creation, created orders are sent to the Dots mock server.</li>
</ul>
<p>Using API: <a href="https://docs.dots.live/">https://docs.dots.live/</a></p>
<p>Using Laravel Framework: <a href="https://laravel.com/">https://laravel.com/</a></p>
<p>Using NGROK: <a href="https://ngrok.com/">https://ngrok.com/</a></p>
<hr>
<h3>To deploy the bot, you need to follow these steps:</h3>
<ul>
    <li>Get the ngrok url and paste it into the .env file at NGROK_URL = ...</li>
    <li>Open the {YOUR_NGROK_URL}/api/setwebhook route to register the webhook with the new url</li>
</ul>
<p align="center"><em>Feel free to reach out with any questions or feedback!</em></p>
