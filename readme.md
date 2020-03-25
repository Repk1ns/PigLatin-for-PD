# **PigLatin translator**

Script read from STDIN, translate English string into PigLatin and result print to the output.

## *Usage:*

### <u>How to run:</u>
Type the following commands at a command prompt:

-`"php src/Reader.php < file"` (file could be random text file with English strings.)

or 

-`"php src/Reader.php"` ,then type some English strings and press Enter.

### <u>Examples:</u>
- 1: `"src/Reader.php < file"` 

where <b>file</b> contains:  Hello world. My name is John. And yours?

Output is:

Ello-hay orld-way. My-way ame-nay is-way Ohn-jay. And-way ours-yay?


- 2: `"php src/Reader.php"`

<b>write into command prompt</b>:  
"Hello world"

<b>Output:</b>  
"Ello-hay orld-way"

In this case press CTRL+C to quit translator.

## *Implementation details:*

Words that do not begin with letters (vowels or consonants) - e.g. numbers are ignored.