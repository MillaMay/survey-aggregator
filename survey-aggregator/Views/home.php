<div class="container home">
    <div class="row mt-4">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <div class="text-center">
                <a href="../?page=add&user=<?= /** @var $data */ $data[0]['id']; ?>" class="btn btn-primary">Add New Survey</a>
            </div>
            <div class="text-center">
                <span class="mr-2"><strong><?= $data[0]['email']; ?></strong></span>
            </div>
            <div class="text-right">
                <a href="../?page=logout" class="btn btn-secondary">Logout</a>
            </div>
        </div>
    </div>

    <?php if (isset($data[0]['date'])): ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="table-responsive">
                    <?php foreach ($data as $key => $value): ?>
                        <div class="border p-3 mb-4 table-gray-bg">
                            <p class="text-center mb-3">Date of creation: <?= date('d, M, Y H:i', strtotime($value['date'])); ?></p>
                            <p class="text-center mb-3">ID: <?= $value['survey_id']; ?></p>
                            <table class="table table-bordered">
                                <thead class="thead-bg">
                                <tr>
                                    <th class="text-left"><?= $value['title']; ?></th>
                                    <th class="text-right col-md-2">
                                        <?php
                                        if ($value['status'] == 1) {
                                            echo "Published";
                                        } else {
                                            echo "Draft";
                                        }
                                        ?>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="tbody-bg">
                                <?php $i = 1; ?>
                                <?php /** @var $answerVotePairs */ foreach ($answerVotePairs[$value['title']] as $answer => $vote): ?>
                                    <tr>
                                        <td class="text-left"><span><?= $i++; ?>. </span><?= $answer; ?></td>
                                        <td class="text-right col-md-2">votes: <span class="td-color"><?= $vote; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between">

                                <form method="post">
                                    <input type="hidden" name="id" value="<?= $value['id']; ?>">
                                    <input type="hidden" name="surveyId" value="<?= $value['survey_id']; ?>">
                                    <input type="hidden" name="status" id="statusField" value="<?= $value['status'] ?>">
                                    <button class="btn btn-success btn-publish" type="submit" onclick="updateStatus()">
                                        <?php
                                        if ($value['status'] == 1) {
                                            echo "To unpublish";
                                        } else {
                                            echo "To publish";
                                        }
                                        ?>
                                    </button>
                                </form>

                                <div>
                                    <a href="../?page=delete&survey=<?= $value['survey_id']; ?>&user=<?= $value['id']; ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
