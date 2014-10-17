<?php

namespace TemaFeed\Model;

class Feed {

    public function getFeedWriterExample() {
        /**
         * Create the parent feed
         */
        $feed = new \Zend\Feed\Writer\Feed;
        $feed->setTitle('Paddy\'s Blog');
        $feed->setLink('http://www.example.com');
        $feed->setFeedLink('http://www.example.com/atom', 'atom');
        $feed->addAuthor(array(
            'name' => 'Paddy',
            'email' => 'paddy@example.com',
            'uri' => 'http://www.example.com',
        ));
        $feed->setDateModified(time());
        $feed->addHub('http://pubsubhubbub.appspot.com/');

        /**
         * Add one or more entries. Note that entries must
         * be manually added once created.
         */
        foreach (range(1,10) as $v) {
            $item = rand(0,999).'/'.$v;
            $entry = $feed->createEntry();
            $entry->setTitle('All '.$item.' Your Base  Are Belong To Us');
            $entry->setLink('http://www.example.com/all-your-base-are-belong-to-us');
            $entry->addAuthor(array(
                'name' => 'Paddy',
                'email' => 'paddy@example.com',
                'uri' => 'http://www.example.com',
            ));
            $entry->setDateModified(time());
            $entry->setDateCreated(time());
            $entry->setDescription('Exposing '.$item.' the difficultly of porting games to English.');
            $entry->setContent(
                    'I am '.$item.' not writing the article. The example is long enough as is ;).'
            );
            $feed->addEntry($entry);
        }

        /**
         * Render the resulting feed to Atom 1.0 and assign to $out.
         * You can substitute "atom" with "rss" to generate an RSS 2.0 feed.
         */
        $out = $feed->export('Rss');
        return $out;
    }

    public function getFeedReaderExample() {
        $feed = \Zend\Feed\Reader\Reader::import('http://elcomercio.feedsportal.com/rss/portada.xml');
        $data = array(
            'title' => $feed->getTitle(),
            'link' => $feed->getLink(),
            'dateModified' => $feed->getDateModified(),
            'description' => $feed->getDescription(),
            'language' => $feed->getLanguage(),
            'entries' => array(),
        );

        foreach ($feed as $entry) {
            $edata = array(
                'title' => $entry->getTitle(),
                'description' => $entry->getDescription(),
                'dateModified' => $entry->getDateModified(),
                'authors' => $entry->getAuthors(),
                'link' => $entry->getLink(),
                'content' => $entry->getContent()
            );
            $data['entries'][] = $edata;
        }
        
        return $data;
    }
    
    
    public function getFeedReaderExercise() {
        $feed = \Zend\Feed\Reader\Reader::import('http://local.czf2.com/tema-feed/index/expose-feed');
        $data = array(
            'title' => $feed->getTitle(),
            'link' => $feed->getLink(),
            'dateModified' => $feed->getDateModified(),
            'description' => $feed->getDescription(),
            'language' => $feed->getLanguage(),
            'entries' => array(),
        );

        foreach ($feed as $entry) {
            $edata = array(
                'title' => $entry->getTitle(),
                'description' => $entry->getDescription(),
                'dateModified' => $entry->getDateModified(),
                'authors' => $entry->getAuthors(),
                'link' => $entry->getLink(),
                'content' => $entry->getContent()
            );
            $data['entries'][] = $edata;
        }
        
        return $data;
    }
    
    public function getFeedWriterExercise() {
        /**
         * Create the parent feed
         */
        $feed = new \Zend\Feed\Writer\Feed;
        $feed->setTitle('FraGoTe\'s Feed');
        $feed->setLink('http://www.francis-gonzales.info');
        $feed->setFeedLink('http://fgonzalestello.wordpress.com/feed/', 'atom');
        $feed->addAuthor(array(
            'name' => 'Francis',
            'email' => 'fgonzalestello91@gmail.com',
            'uri' => 'http://www.francis-gonzales.info',
        ));
        $feed->setDateModified(time());
        $feed->addHub('http://www.francis-gonzales.info');

        /**
         * Add one or more entries. Note that entries must
         * be manually added once created.
         */
        foreach (range(1,3) as $v) {
            $item = rand(0,999).'/'.$v;
            $entry = $feed->createEntry();
            $entry->setTitle('Feed N° ' . $item);
            $entry->setLink('http://fgonzalestello.wordpress.com/feed/' . $item);
            $entry->addAuthor(array(
                'name' => 'Feed Exercise ' . $item,
                'email' => $item . '@example.com',
                'uri' => 'http://www.francis-gonzales.info/rss/' . $item,
            ));
            $entry->setDateModified(time());
            $entry->setDateCreated(time());
            $entry->setDescription('This is the feed N° ' . $item);
            $entry->setContent('This is the content number ' . $item);
            $feed->addEntry($entry);
        }

        /**
         * Render the resulting feed to Atom 1.0 and assign to $out.
         * You can substitute "atom" with "rss" to generate an RSS 2.0 feed.
         */
        $out = $feed->export('atom');
        return $out;
    }

}
