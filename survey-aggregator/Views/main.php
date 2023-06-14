<div class="container">
    <h1>Агрегатор для проведения фиктивных опросов</h1>
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success text-center" role="alert">
            <?= $successMessage ?>
        </div>
    <?php endif; ?>
    <h2>Login:</h2>

    <form method="POST" id="login">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <p>Don't have an account? <a href="../?page=registration">Register</a></p>
</div>
