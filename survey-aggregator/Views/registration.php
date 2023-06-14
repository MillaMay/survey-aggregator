<div class="container">
    <h1>Registration:</h1>
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/?registration.php">
        <input type="hidden" name="action" value="register">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <p>Already have an account? <a href="/">Login</a></p>
</div>
