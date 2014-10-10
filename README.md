AuthorControl
=============

Open-source SIMPLE system for display "author's works" (geared towards books, but might be used for other sorts of products).

Uses JSON files to store information and a schema system to translate that information for an index.php that is shown to users. Edit panels allow editing of site-wide options and text (as well as adding, editing, and maintaining "works")

- options.json      : Stores information about the works
- lang_english.json : Stores text information (eventually language support)
- review.json       : Stores information regarding reviews
- schema.json       : Stores the fields and behavior rules regarding how to display those fields
