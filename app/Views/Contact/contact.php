<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">
            <h1 style="margin-bottom: 5px">Contact form page</h1>
            <form action="/framework.loc/contact" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">content</label>
                    <textarea class="form-control" name="content" id="content" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-light">Send</button>
            </form>
        </div>
    </div>

</div>