<form action="/todos" method="post" class="row row-cols-lg-auto py-4">
    <div class="col-12">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/c4497f215d.js" crossorigin="anonymous"></script>
        <label for="textInput" class="form-label">Text Input</label>
        <input type="text" id="textInput" class="form-control" name="text" aria-label="Text input field" required>
    </div>
    <button type="submit" class="btn btn-primary">+</button>
</form>