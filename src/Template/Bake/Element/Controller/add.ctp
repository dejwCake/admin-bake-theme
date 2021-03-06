<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$compact = ["'" . $singularName . "'"];
%>

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $<%= $singularName %> = $this-><%= $currentModelName %>->newEntity();
        if ($this->request->is('post')) {
<% if($createdBy): %>
            $this->request->data('created_by', $this->Auth->user('id'));
<% endif %>
<% if($translation): %>
            $<%= $singularName %> = $this-><%= $currentModelName %>->patchEntity($<%= $singularName %>, $this->request->data, [
                'translations' => true
            ]);
<% else: %>
            $<%= $singularName %> = $this-><%= $currentModelName %>->patchEntity($<%= $singularName %>, $this->request->data);
<% endif %>
            if ($this-><%= $currentModelName; %>->save($<%= $singularName %>)) {
                $this->Flash->success(__('The <%= strtolower($singularHumanName) %> has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                Log::error('Entity could not be saved. Entity: '.var_export($<%= $singularName %>, true));
                $this->Flash->error(__('The <%= strtolower($singularHumanName) %> could not be saved. Please, try again.'));
            }
        }
<%

        $associations = array_merge(
            $this->Bake->aliasExtractor($modelObj, 'BelongsTo'),
            $this->Bake->aliasExtractor($modelObj, 'BelongsToMany')
        );
        foreach ($associations as $assoc):
            $association = $modelObj->association($assoc);
            if(!in_array($association->foreignKey(), $skipAssociations)):
                $otherName = $association->target()->alias();
                $otherPlural = $this->_variableName($otherName);
                if(strpos($otherName, 'Parent') === false):
%>
        $<%= $otherPlural %> = $this-><%= $currentModelName %>-><%= $otherName %>->find('list', ['limit' => 200]);
<%
                else:
%>
        $<%= $otherPlural %> = $this-><%= $currentModelName %>-><%= $otherName %>->find('treeList', ['limit' => 200]);
<%
                endif;
                $compact[] = "'$otherPlural'";
            endif;
        endforeach;
%>
<% if($enabledInLocales): %>
        $enabledInLocales = $this->getLocales();
<%
        $compact[] = "'enabledInLocales'";
    endif;
%>
<% if($view): %>
        $views = $this-><%= $currentModelName %>->getViews();
<%
        $compact[] = "'views'";
    endif;
%>
<% if($collection): %>
        $collections = $this-><%= $currentModelName %>->getMediaCollections();
<%
        $compact[] = "'collections'";
    endif;
%>
        $this->set(compact(<%= join(', ', $compact) %>));
        $this->set('_serialize', ['<%=$singularName%>']);
    }
