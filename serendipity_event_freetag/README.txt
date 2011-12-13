Using this subquery you can convert existing categories to tags:

INSERT INTO serendipity_entrytags (entryid, tag) 
  SELECT serendipity_entries.id, serendipity_category.category_name 
    FROM serendipity_entries, serendipity_category, serendipity_entrycat 
   WHERE serendipity_entrycat.entryid = serendipity_entries.id 
     AND serendipity_category.categoryid = serendipity_entrycat.categoryid;

[quoted from: http://pixelated-dreams.com/archives/229-Spring-Cleaning.html]

Or using this script you can convert existing categories to tags:

<?php
include 'serendipity_config.inc.php';

$rows = serendipity_db_query("SELECT e.id, e.title, c.category_name
                                FROM {$serendipity['dbPrefix']}entries AS e
                                JOIN {$serendipity['dbPrefix']}entrycat AS ec
                                  ON ec.entryid = e.id
                                JOIN {$serendipity['dbPrefix']}category AS c
                                  ON ec.categoryid = c.categoryid");

foreach($rows AS $row) {
    serendipity_db_query(
        sprintf(
            "REPLACE INTO {$serendipity['dbPrefix']}entrytags (entryid, tag) VALUES (%d, %s)",
            (int)$row['id'],
            serendipity_db_escape_string($row['category_name'])
        )
    );
    
    printf(
        "Category '%s' added as Tag for Entry #%d, '%s'<br />\n",
        htmlspecialchars($row['category_name']),
        (int)$row['id'],
        htmlspecialchars($row['title'])
    );
}