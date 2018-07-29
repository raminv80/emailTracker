<div class="container">
    <div class="row align-items-center">
        <form class="col-md-10 offset-md-1 col-lg-6 offset-lg-3 needs-validation"
              novalidate method="post" action="/ajax-submit" id="emailForm"
        id="asda">
            <div class="form-group">
                <label for="email">To:</label>
                <input name="email" type="email" required class="form-control" id="email"
                       placeholder="Recipients">
                <div class="invalid-feedback">
                    Please enter a valid email for recipient.
                </div>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input name="subject" type="input" required class="form-control" id="subject" placeholder="Email subject">
                <div class="invalid-feedback">
                    Please enter the subject of this email.
                </div>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" rows="10" id="message" required name="message"
                          placeholder="Email message"></textarea>
                <div class="invalid-feedback">
                    Email message is required.
                </div>
            </div>
            <button type="submit" id="submit" class="btn btn-primary"><span class="label">Submit</span>
                <span class="loader"></span></button>
        </form>
    </div>
</div>
