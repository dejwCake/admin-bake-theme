<%
use Cake\Utility\Inflector;
%>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= __('<%= $pluralHumanName %>'); ?>
    </h1>
    <ol class="breadcrumb">
        <li>
            <?= $this->Html->link('<i class="fa fa-dashboard"></i> ' . __('Back'), ['action' => 'index'], ['escape' => false]) ?>
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= __('Sort <%= $pluralHumanName %>') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if($<%= $pluralVar %>->count()): ?>
                        <ol class="sortable ids ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded" id="sortable">
                            <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
                                <?= $this->element('DejwCake/AdminLTE.nestedList', ['item' => $<%= $singularVar %>]);?>
                            <?php endforeach; ?>
                        </ol>
                    <?php else: ?>
                        <?= __('No <%= $pluralHumanName %> to sort.') ?>
                    <?php endif; ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php if($<%= $pluralVar %>->count() && !empty($<%= $singularVar %>)): ?>
                        <?= $this->Form->create($<%= $singularVar %>, ['role' => 'form', 'id' => 'treeSortForm']) ?>
                            <input type="hidden" name="ids" value="[]" />
                            <?= $this->Form->button(__('Save')) ?>
                        <?= $this->Form->end() ?>
                    <?php endif; ?>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->

<?php $this->append('css'); ?>
<?php echo $this->Html->css('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css'); ?>
<?php echo $this->Html->css('DejwCake/AdminLTE./plugins/nestedSortable/jquery.mjs.nestedSortable'); ?>
<?php $this->end(); ?>
<?php $this->append('scriptBottom'); ?>
<?php echo $this->Html->script('DejwCake/AdminLTE./plugins/jQueryUI/jquery-ui'); ?>
<?php echo $this->Html->script('DejwCake/AdminLTE./plugins/nestedSortable/jquery.mjs.nestedSortable'); ?>
<script>
    $(function () {
        $('.sortable').nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div',
            isTree: true,

            forcePlaceholderSize: true,
            helper:	'clone',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            maxLevels: 3,
            expandOnHover: 700,
            startCollapsed: false,
            excludeRoot: true,
            change: function(){
            }
        });

        $('#treeSortForm').submit(function(event) {
            var arrayed = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
            $(this).find('[name="ids"]').val(JSON.stringify(arrayed));
            return true;
        });
    });
</script>
<?php $this->end(); ?>