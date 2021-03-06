<%
use Cake\Utility\Inflector;

$ckeditor = false;
%>
<section class="content-header">
    <h1>
        <?= __('<%= $singularHumanName %>') ?>
        <small><?= __('<%= Inflector::humanize($action) %>') ?></small>
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
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= __('Form') ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= $this->Form->create($<%= $singularVar %>, ['role' => 'form']) ?>
                <div class="box-body">
                    <?php
<%
                    foreach ($fields as $field) {
                        if(in_array($field, $skipFormFields) || in_array($field, $translateFields)) {
                            continue;
                        }
                        if (in_array($field, $primaryKey)) {
                            continue;
                        }
                        if (isset($keyFields[$field])) {
                            $fieldData = $schema->column($field);
                            if (!empty($fieldData['null'])) {
%>
                        echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true, 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                            } else {
%>
                        echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                            }
                            continue;
                        }
                        if (!in_array($field, ['created', 'modified', 'updated', 'deleted', 'remember_token'])) {
                            $fieldData = $schema->column($field);
                            if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
%>
                        echo $this->Form->input('<%= $field %>', ['empty' => true, 'default' => '', 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                            } else if(in_array($fieldData['type'], ['text'])) {
                                $ckeditor = true;
%>
                        echo $this->Form->input('<%= $field %>', ['class' => 'ckeditor', 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                            } else if($field == 'enabled_in_locales') {
%>
                        echo $this->Form->input('<%= $field %>', ['options' => $enabledInLocales, 'class' => 'select2', 'data-placeholder' => __("Select Locale"), 'multiple' => true, 'required' => false, 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                            } else {
%>
                        echo $this->Form->input('<%= $field %>', ['label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                            }
                        }
                    }
%>
                    ?>
<%
                    if(!empty($translateFields)) {
%>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                        <?php $i = 0; ?>
                        <?php foreach ($supportedLanguages as $language => $languageSettings): ?>
                            <li <?php if ($selectedLanguage == $language): ?>class="active"<?php endif; ?>><a
                                        href="#tab_<?= $i ?>" data-toggle="tab"><?= $language ?></a></li>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                        </ul>
                        <div class="tab-content">
                        <?php $i = 0; ?>
                        <?php foreach ($supportedLanguages as $language => $languageSettings): ?>
                            <div class="tab-pane <?php if ($selectedLanguage == $language): ?>active<?php endif; ?>"
                                 id="tab_<?= $i ?>">
                                <?php
                                    if($languageSettings['locale'] == $defaultLocale){
<%
                                foreach ($fields as $field) {
                                    if(in_array($field, $skipFormFields)) {
                                        continue;
                                    }
                                    if(in_array($field, $translateFields)) {
                                        if (in_array($field, $primaryKey)) {
                                            continue;
                                        }
                                        if (isset($keyFields[$field])) {
                                            $fieldData = $schema->column($field);
                                            if (!empty($fieldData['null'])) {
%>
                                        echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true, 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                                            } else {
%>
                                        echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                                            }
                                            continue;
                                        }
                                        if (!in_array($field, ['created', 'modified', 'updated', 'deleted'])) {
                                            $fieldData = $schema->column($field);
                                            if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
%>
                                        echo $this->Form->input('<%= $field %>', ['empty' => true, 'default' => '', 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                                            } else if(in_array($fieldData['type'], ['text'])) {
                                                $ckeditor = true;
%>
                                        echo $this->Form->input('<%= $field %>', ['class' => 'ckeditor', 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                                            } else {
%>
                                        echo $this->Form->input('<%= $field %>', ['label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                                            }
                                        }
                                    }
                                }
%>
                                    } else {
<%
                                foreach ($fields as $field) {
                                    if(in_array($field, $skipFormFields)) {
                                        continue;
                                    }
                                    if(in_array($field, $translateFields)) {
                                        if (in_array($field, $primaryKey)) {
                                            continue;
                                        }
                                        if (isset($keyFields[$field])) {
                                            $fieldData = $schema->column($field);
                                            if (!empty($fieldData['null'])) {
%>
                                        echo $this->Form->input('_translations.' . $languageSettings['locale'] . '.<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true, 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                                            } else {
%>
                                        echo $this->Form->input('_translations.' . $languageSettings['locale'] . '.<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                                            }
                                            continue;
                                        }
                                        if (!in_array($field, ['created', 'modified', 'updated', 'deleted'])) {
                                            $fieldData = $schema->column($field);
                                            if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
%>
                                        echo $this->Form->input('_translations.' . $languageSettings['locale'] . '.<%= $field %>', ['empty' => true, 'default' => '', 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                                            } else if(in_array($fieldData['type'], ['text'])) {
                                                $ckeditor = true;
%>
                                        echo $this->Form->input('_translations.' . $languageSettings['locale'] . '.<%= $field %>', ['class' => 'ckeditor', 'label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                                            } else {
%>
                                        echo $this->Form->input('_translations.' . $languageSettings['locale'] . '.<%= $field %>', ['label' => __('<%= Inflector::humanize(Inflector::underscore($field)) %>')]);
<%
                                            }
                                        }
                                    }
                                }
%>
                                    }
                                ?>
                            </div>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
<%
                    }
                    if (!empty($associations['BelongsToMany'])) {
                        foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
                    <?php
                        echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>, 'class' => 'select2', 'data-placeholder' => __("Select <%= Inflector::singularize($assocName) %>")]);
                    ?>
<%
                        }
                    }
%>
                    <?php
<%
                    if($media) {
%>
                        //Media part
                        echo $this->element('DejwCake/Media.Resource/fetch');
                        echo $this->element('DejwCake/Media.Form/Template/template_all');
                        echo $this->element('DejwCake/Media.Form/media_all', ['collections' => $collections, 'object' => $<%= $singularVar %>]);
<%
                    }
%>
                    ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?= $this->Form->button(__('Save')) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>

<?php $this->append('css'); ?>
<?php echo $this->Html->css('DejwCake/AdminLTE./plugins/iCheck/all.css'); ?>
<?php $this->end(); ?>
<?php $this->append('cssFirst'); ?>
<?php echo $this->Html->css('DejwCake/AdminLTE./plugins/select2/select2.min.css'); ?>
<?php $this->end(); ?>
<?php $this->append('scriptBottom'); ?>
<?php echo $this->Html->script('DejwCake/AdminLTE./plugins/iCheck/icheck.min.js'); ?>
<?php echo $this->Html->script('DejwCake/AdminLTE./plugins/select2/select2.full.min.js'); ?>
<%
    if($ckeditor) {
%>
<?php echo $this->Html->script('DejwCake/AdminLTE./plugins/ckeditor/ckeditor.js'); ?>
    <script type="text/javascript">
        $(function () {
            CKEDITOR.replaceAll('ckeditor');
        });
    </script>
<%
    }
%>
    <script type="text/javascript">
        $(".select2").select2();
        $(function () {
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        });
    </script>
<?php $this->end(); ?>
