<?php
class Methods{
    const CONNECT 	= 'system.connect';
    // const SERVICES_GET = 'system.getServices';
    const SYSTEM_GET = 'system.get_variable';
    const SYSTEM_SET = 'system.set_variable';
    const SYSTEM_DELETE = 'system.del_variable';

    const LOGIN		= 'user.login';
    const LOGOUT	= 'user.logout';

    const USER_CREATE = 'user.create';
    const USER_LOAD = 'user.retrieve';
    const USER_UPDATE = 'user.update';
    const USER_DELETE = 'user.delete';
    const USER_LIST = 'user.index';

    const NODE_CREATE = 'node.create';
    const NODE_GET	= 'node.retrieve';
    const NODE_SAVE = 'node.update';
    const NODE_DELETE = 'node.delete';
    const NODE_LIST = 'node.index';

    const COMMENT_CREATE = 'comment.create';
    const COMMENT_GET  = 'comment.retrieve';
    const COMMENT_SAVE = 'comment.update';
    const COMMENT_DELETE = 'comment.delete';

    const FILE_CREATE = 'file.create';
    const FILE_GET  = 'file.retrieve';
    const FILE_DELETE = 'file.delete';
    const FILE_LIST = 'file.index';

    const TERM_CREATE = 'taxonomy_term.create';
    const TERM_GET  = 'taxonomy_term.retrieve';
    const TERM_SAVE = 'taxonomy_term.update';
    const TERM_DELETE = 'taxonomy_term.delete';

    const VOCABULARY_CREATE = 'taxonomy_vocabulary.create';
    const VOCABULARY_GET  = 'taxonomy_vocabulary.retrieve';
    const VOCABULARY_SAVE = 'taxonomy_vocabulary.update';
    const VOCABULARY_DELETE = 'taxonomy_vocabulary.delete';


    const SEARCH_NODES = 'search.nodes';

    public function __get($name){
        if (!constant($constant = get_class($this) . '::' . $name)) {
            throw new Exception('Invalid ' . get_class($this) . ' const');
        }
        return constant($constant);
    }
}