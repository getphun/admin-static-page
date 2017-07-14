<?php
/**
 * Page management
 * @package admin-static-page
 * @version 0.0.1
 * @upgrade true
 */

namespace AdminStaticPage\Controller;
use StaticPage\Model\StaticPage as SPage;

class PageController extends \AdminController
{
    private function _defaultParams(){
        return [
            'title'             => 'Static Page',
            'nav_title'         => 'Static Page',
            'active_menu'       => 'static-page',
            'active_submenu'    => 'static-page',
            'total'             => 0,
            'pagination'        => []
        ];
    }
    
    public function editAction(){
        if(!$this->user->login)
            return $this->show404();
        
        $id = $this->param->id;
        if(!$id && !$this->can_i->create_static_page)
            return $this->show404();
        elseif($id && !$this->can_i->update_static_page)
            return $this->show404();
        
        $old = null;
        $params = $this->_defaultParams();
        $params['title'] = 'Create New Static Page';
        $params['ref'] = $this->req->getQuery('ref') ?? $this->router->to('adminStaticPage');
        
        if($id){
            $params['title'] = 'Edit Static Page';
            $object = SPage::get($id, false);
            if(!$object)
                return $this->show404();
            $old = $object;
        }else{
            $object = new \stdClass();
            $object->user = $this->user->id;
        }
        
        if(false === ($form=$this->form->validate('admin-static-page', $object)))
            return $this->respond('static-page/edit', $params);
        
        $object = object_replace($object, $form);
        
        $event = 'updated';
        
        if(!$id){
            $event = 'created';
            if(false === ($id = SPage::create($object)))
                throw new \Exception(SPage::lastError());
        }else{
            $object->updated = null;
            if(false === SPage::set($object, $id))
                throw new \Exception(SPage::lastError());
        }
        
        $this->fire('static-page:'. $event, $object, $old);
        
        return $this->redirect($params['ref']);
    }
    
    public function indexAction(){
        if(!$this->user->login)
            return $this->loginFirst('adminLogin');
        if(!$this->can_i->read_static_page)
            return $this->show404();
        
        $params = $this->_defaultParams();
        $params['reff']  = $this->req->url;
        $params['pages'] = [];
        
        $page = $this->req->getQuery('page', 1);
        $rpp  = 20;
        
        $pages = SPage::get([], $rpp, $page, 'title ASC');
        if($pages)
            $params['pages'] = \Formatter::formatMany('static-page', $pages, false, false);
        
        $params['total'] = $total = SPage::count([]);
        
        if($total > $rpp)
            $params['pagination'] = \calculate_pagination($page, $rpp, $total);
        
        return $this->respond('static-page/index', $params);
    }
    
    public function removeAction(){
        if(!$this->user->login)
            return $this->show404();
        if(!$this->can_i->remove_static_page)
            return $this->show404();
        
        $id = $this->param->id;
        $object = SPage::get($id, false);
        if(!$object)
            return $this->show404();
        
        $this->fire('static-page:deleted', $object);
        SPage::remove($id);
        
        $ref = $this->req->getQuery('ref');
        if($ref)
            return $this->redirect($ref);
        
        return $this->redirectUrl('adminStaticPage');
    }
}