Build the following lab to demonstrate XSS:

- VM 1, LAMP-Stack with blog-platform (vulnerable blog)
- VM/Host for Cookie Stealing (see cookie stealer or flask grabber)
- Enable web-facing session hijacking with cloudflare tunnel (see how-to)

Vulnerable target's file structure:
html/
└── blog/
    ├── authenticate.php  --> check credentials
    ├── index.php         --> home page, requires login
    ├── login.html        --> Login-Page to POST credentials
    ├── posts.json        --> Database for Blogposts
    ├── save_post.php     --> writes a blogpost into posts.json 
    └── styles.css        --> CSS

Attacker's Apache-Server file structure:
html/
├── Cookies.txt           --> cookie-database with timestamps 
├── grabber.js            --> Receives cookie after XSS-execution and forwards it to saver.php
└── saver.php             --> Generates timestamp, saves cookie to txt-File

Alternative attacker server:
- Flask-server for temporary saving of cookies (see flask_cookie_grabber.py)
