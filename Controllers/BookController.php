<?php

namespace App\Controllers;

use App\Models\Book;

class BookController extends BaseController {
    
        public static function list () {
            //zoekterm opvangen
            $search = $_GET['search'] ?? '';

            $list = Book::search($search);

            // foreach ($list as $item) {
            //     if( strpos($item->title, $search) !== false) {
            //         echo $item->title . 'is een hit';
            //     }
            // }

            self::loadView('books/list', [
                'list' => $list,
                'search' => $search
            ]);
        }

        public static function detail ($id) {

            self::loadView('books/detail', [
                'book' => Book::find($id)
            ]);

        }

        public static function add () {
            self::loadView('books/form');
        }

        public static function save() {

            $book = new Book();
            $book->title = $_POST['title'];
            $book->description = $_POST['description'];
            // print_r($book);

            $succes = $book->save();

            if($succes) {
                header('Location: /books');
                parent::redirect('/books');
            } else {
                echo 'Error';
            }

        }
}