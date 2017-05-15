
<div class="pure-g">
    <div class="pure-u-1-3"></div>
    <div class="pure-u-1-3">
        <div class="pure-button-group pagination-buttons" role="group" aria-label="pagination">
            <?php foreach ($pagination as $page): ?>
                <?php if ($page['isCurrent']): ?>
                    <a class="pure-button pure-button-disabled pure-button-active"><?= $page['pageName'] ?></a>
                <?php else: ?>
                    <a class="pure-button" href="<?= $page['pathFor'] ?>"><?= $page['pageName'] ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
