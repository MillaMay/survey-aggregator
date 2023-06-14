<div class="container add">
    <h2>Adding a new survey</h2>
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success text-center">
            <?php echo $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <form method="POST" id="addForm">
        <div class="form-group">
            <label for="question">Question:</label>
            <input type="text" class="form-control" id="question" name="question" required>
        </div>

        <div class="form-group">
            <label for="answer">Answer and votes:</label>
            <div class="answer-group">
                <div class="answer-item">
                    <input type="text" class="form-control" name="answer[]" required>
                    <input type="number" class="form-control vote-input" name="votes[]" min="0" required>
                </div>
            </div>
            <button type="button" class="btn btn-success btn-add-answer">Add another answer</button>
        </div>

        <input type="hidden" name="user_id" value="<?= /** @var $user_id */ $user_id; ?>">

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <div class="text-center mt-4">
        <a href="/?page=home&user=<?= $user_id; ?>" class="btn btn-secondary">Go back to Home page</a>
    </div>
</div>
