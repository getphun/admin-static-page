<?php
/**
 * admin-static-page config file
 * @package admin-static-page
 * @version 0.0.1
 * @upgrade true
 */

return [
    '__name' => 'admin-static-page',
    '__version' => '0.0.1',
    '__git' => 'https://github.com/getphun/admin-static-page',
    '__files' => [
        'modules/admin-static-page' => [ 'install', 'remove', 'update' ],
        'theme/admin/static-page'   => [ 'install', 'remove', 'update' ]
    ],
    '__dependencies' => [
        'static-page',
        'admin'
    ],
    '_services' => [],
    '_autoload' => [
        'classes' => [
            'AdminStaticPage\\Controller\\PageController' => 'modules/admin-static-page/controller/PageController.php'
        ],
        'files' => []
    ],
    
    '_routes' => [
        'admin' => [
            'adminStaticPage' => [
                'rule' => '/page',
                'handler' => 'AdminStaticPage\\Controller\\Page::index'
            ],
            'adminStaticPageEdit' => [
                'rule' => '/page/:id',
                'handler' => 'AdminStaticPage\\Controller\\Page::edit'
            ],
            'adminStaticPageRemove' => [
                'rule' => '/page/:id/remove',
                'handler' => 'AdminStaticPage\\Controller\\Page::remove'
            ]
        ]
    ],
    
    'admin' => [
        'menu' => [
            'static-page' => [
                'label'     => 'Static Page',
                'order'     => 30,
                'icon'      => 'file-text',
                'perms'     => 'read_static_page',
                'target'    => 'adminStaticPage'
            ]
        ]
    ],
    
    'form' => [
        'admin-static-page' => [
            'title' => [
                'type'      => 'text',
                'label'     => 'Title',
                'rules'     => [
                    'required'  => true
                ]
            ],
            'slug' => [
                'type'      => 'text',
                'label'     => 'Slug',
                'attrs'     => [
                    'data-slug' => '#field-title'
                ],
                'rules'     => [
                    'required'  => true,
                    'alnumdash' => true,
                    'unique' => [
                        'model' => 'StaticPage\\Model\\StaticPage',
                        'field' => 'slug',
                        'self'  => [
                            'uri'   => 'id',
                            'field' => 'id'
                        ]
                    ]
                ]
            ],
            'content' => [
                'type'      => 'wysiwyg',
                'label'     => 'Content',
                'rules'     => []
            ],
            'meta_schema' => [
                'type'      => 'select',
                'label'     => 'Schema Type',
                'options'   => [
                    'WebPage'           => 'WebPage',
                    'AboutPage'         => 'AboutPage',
                    'ContactPage'       => 'ContactPage',
                    'ProfilePage'       => 'ProfilePage',
                    'QAPage'            => 'QAPage',
                    'SearchResultsPage' => 'SearchResultsPage'
                ],
                'rules'     => []
            ],
            'meta_title' => [
                'type'      => 'text',
                'label'     => 'Meta Title',
                'rules'     => []
            ],
            'meta_description' => [
                'type'      => 'textarea',
                'label'     => 'Meta Description',
                'rules'     => []
            ],
            'meta_keywords' => [
                'type'      => 'text',
                'label'     => 'Meta Keywords',
                'rules'     => []
            ]
        ]
    ]
];