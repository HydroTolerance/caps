<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <div class="container mt-5">
        <form method="post" action="faq.php">
            <div class="mb-3">
                <label for="question" class="form-label">Question:</label>
                <input type="text" class="form-control" name="question" required>
            </div>
            <div class="mb-3">
                <label for="answer" class="form-label">Answer:</label>
                <input type="text" class="form-control" name="answer" required>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn text-white" style="background-color: #6537AE;">Submit</button>
                <a href="faq.php" class="btn btn-secondary">Cancel</a>
            </div>

        </form>
    </div>
</body>
</html>
