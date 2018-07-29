# Email Tracker

Sends an event using a SMTP server and tracks email views


- Assumes apache rewrite engine is available
- tried not to use a framework for backend
- frontend dependencies come from CDN
- PHPMailer is used to send email
- MicroDB provides a basic db management layer to avoid potential sql injections
- Pixel triggers GA event (not GTM)
- DotEnv is used to avoid accidental submission of credentials to public repositories
