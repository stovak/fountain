<?php

namespace Fountain;

use Fountain\Elements\Action;
use Fountain\Elements\BlankLine;
use Fountain\Elements\Boneyard;
use Fountain\Elements\Character;
use Fountain\Elements\Dialogue;
use Fountain\Elements\DualDialogue;
use Fountain\Elements\Lyrics;
use Fountain\Elements\NewLine;
use Fountain\Elements\Notes;
use Fountain\Elements\PageBreak;
use Fountain\Elements\Parenthetical;
use Fountain\Elements\SceneHeading;
use Fountain\Elements\SectionHeading;
use Fountain\Elements\Synopsis;
use Fountain\Elements\TextCenter;
use Fountain\Elements\Transition;

/**
 * FountainParser
 * Based off the FastFountainParser.m.
 *
 * https://github.com/alexking/Fountain-PHP
 *
 * @author Alex King (PHP port)
 * @author Nima Yousefi & John August (original Objective-C version)
 */
class FountainParser
{
    /**
     * Element Collection.
     *
     * @var FountainElementIterator
     */
    protected FountainElementIterator $_elements;

    /**
     * FountainParser constructor.
     */
    public function __construct()
    {
        $this->_elements = new FountainElementIterator();
    }


    /**
     * Parse a string into a collection of elements.
     *
     * @param string $contents Fountain formatted text
     *
     * @return FountainElementIterator
     */
    public function parse(string $contents): FountainElementIterator
    {
        //-----------------------------------------------------
        // Prepare the file contents
        //-----------------------------------------------------

        // trim newlines from the document
        $contents = trim($contents);

        // convert \r\n or \r style newlines to \n
        $contents = preg_replace("/\r\n|\r/", "\n", $contents);

        // add two lines and an end element to the document
        $contents .= "\n\n<<<END";

        // keep track of the first line for processing certain elements
        $first_line = true;
        $last_line = false;

        // keep track of whether we are inside a comment block, and what its text is
        $comment_block = false;
        $comment_text = '';

        //-----------------------------------------------------
        // Process each line separately
        //-----------------------------------------------------

        // split the contents into lines
        $lines = explode("\n", $contents);

        // process each line
        foreach ($lines as $line_number => $line) {
            // keep track of the first line
            if ($line_number > 0) {
                $first_line = false;
            }

            // determine if this is the last line
            if ('<<<END' === $line) {
                $last_line = true;
                $line = '';
            }

            /*
             * -----------------------------------------------------
             * Blank Lines (two spaces)
             * -----------------------------------------------------
             */

            if ((new BlankLine())->match($line)) {
                // check if the previous element was dialogue
                if ($this->elements()->last() && $this->elements()->last()->is(Dialogue::class)) {
                    // add a blank line to the previous dialog for rendering
                    $this->elements()->last()->appendText(PHP_EOL.PHP_EOL);
                }

                continue;                   // no further processing needed
            }

            /**
             * -----------------------------------------------------
             * New Lines (empty line)
             * -----------------------------------------------------.
             */
            // assert if this is a new line
            $assertNewLine = (new NewLine())->match($line) && !$comment_block;
            if ($last_line) {
                $assertNewLine = false;
            }

            // check for a blank line
            if ($assertNewLine) {
                $this->elements()->addElement(new NewLine());

                continue;                   // no further processing needed
            }

            /**
             * -----------------------------------------------------
             * Synopsis
             * -----------------------------------------------------
             * If there aren't any preceding newlines, and there's a "=".
             */
            // check if there is a blank line before this element
            // or if this element is on the first line
            $assertNewline = ($this->elements()->last()->is(NewLine::class) || $first_line);
            $assertSynopsis = ($assertNewline && (new Synopsis())->match($line));

            if ($assertSynopsis) {
                $synopsis = (new Synopsis())->create($line);
                $synopsis->first = ($first_line);
                $this->elements()->addElement($synopsis);

                continue;                   // no further processing needed
            }

            /**
             * -----------------------------------------------------
             * Boneyard Blocks
             * -----------------------------------------------------.
             */

            // check whether a comment starts or ends on this line
            $boneyard = (new Boneyard())->match($line);
            $assertComments = ($boneyard || $comment_block);

            // if this is the start, middle, or end of a comment block
            if ($assertComments) {
                // if the comment ends on this line
                if ($boneyard && $comment_block) {
                    $comment_text = (new Boneyard())->sanitize($line);
                    $boneyard_element = (new Boneyard())->create($comment_text);
                    $this->elements()->addElement($boneyard_element);
                    $comment_block = false;
                    $comment_text = ''; // reset the text
                }

                // if it starts on this line
                if ($boneyard && !$comment_block) {
                    $comment_block = true;
                }

                // if the comment continues on this line
                if (!$boneyard && $comment_block) {
                    $comment_text .= "{$line}\n";
                }

                continue;                   // no further processing needed
            }

            /*
             * -----------------------------------------------------
             * Page Breaks
             * -----------------------------------------------------
             */

            if ((new PageBreak())->match($line)) {
                // add a page break element
                $this->elements()->addElement(new PageBreak());

                continue;                   // no further processing needed
            }

            /**
             * -----------------------------------------------------
             * Lyrics
             * -----------------------------------------------------
             * If there is a preceding newline, and there's a "~"
             * Additional lyrical lines will be appended later.
             */
            $assertLyrics = ($this->elements()->lastElementIsNewline() && (new Lyrics())->match($line));

            if ($assertLyrics) {
                $lyrics = (new Lyrics())->create($line);
                $this->elements()->addElement($lyrics);

                continue;                   // no further processing needed
            }

            /*
             * -----------------------------------------------------
             * Action
             * -----------------------------------------------------
             * If there's a forced action "!"
             * Additional action lines will be appended later.
             */

            if ((new Action())->match($line)) {
                $action = (new Action())->create($line);
                $this->elements()->addElement($action);

                continue;                   // no further processing needed
            }

            /*
             * -----------------------------------------------------
             * Notes
             * -----------------------------------------------------
             */

            if ($this->elements()->lastElementIsNewline() && (new Notes())->match($line)) {
                $notes = (new Notes())->create($line);
                $this->elements()->addElement($notes);
                $this->elements()->addElement(new NewLine());

                continue;                   // no further processing needed
            }

            /**
             * -----------------------------------------------------
             * Section Headings
             * -----------------------------------------------------
             * check if this line starts with a #.
             */
            $assertSection = (new SectionHeading())->match($line);
            $assertSection = ($this->elements()->lastElementIsNewline() && $assertSection);

            if ($assertSection) {
                // add a section heading
                $sectionHeading = (new SectionHeading())->create($line);
                $this->elements()->addElement($sectionHeading);
                $this->elements()->addElement(new NewLine());

                continue;                   // no further processing needed
            }

            /*
             * -----------------------------------------------------
             * Scene Headings
             * -----------------------------------------------------
             */

            if ((new SceneHeading())->match($line)) {
                $scene = (new SceneHeading())->create($line);
                $this->elements()->addElement($scene);
                $this->elements()->addElement(new NewLine());

                continue;                   // no further processing needed
            }

            /*
             * -----------------------------------------------------
             * Centered
             * -----------------------------------------------------
             * Check whether the line starts with > and ends with <
             */

            if ((new TextCenter())->match($line)) {
                $text = (new TextCenter())->create($line);

                // check if the previous element was centered
                if ($this->elements()->last() && $this->elements()->last()->is(TextCenter::class)) {
                    // the previous element was centered, so we can combine the text.
                    $this->elements()->last()->appendText(PHP_EOL.$text);
                } else {
                    $this->elements()->addElement($text);
                }

                continue;                   // no further processing needed
            }

            /*
             * -----------------------------------------------------
             * Transitions
             * -----------------------------------------------------
             * This element will be parsed but not included in the output.
             */

            if ((new Transition())->match($line)) {
                $text = (new Transition())->create($line);
                $this->elements()->addElement($text);

                continue;                   // no further processing needed
            }

            /**
             * -----------------------------------------------------
             * Character
             * -----------------------------------------------------
             * check if there is a newline preceding (or first line)
             * and consists of entirely uppercase characters.
             */

            // check if there is a blank line before this element
            // or if this element is on the first line
            $assertNewline = ($this->elements()->lastElementIsNewline() || $first_line);

            // assert a character element
            $assertCharacter = $assertNewline && (new Character())->match($line);

            if ($assertCharacter) {
                // make sure the next line isn't blank or non-existent
                if (isset($lines[$line_number + 1]) && '' != $lines[$line_number + 1]) {
                    // this is a character, check if it's dual dialog
                    $dual_dialog = false;

                    if ((new DualDialogue())->match($line)) {
                        // it is dual dialog,
                        $dual_dialog = true;

                        // check for a previous character - grab it by reference if it exists
                        if ($previous_character = &$this->elements()->findLastElementOfType(Character::class)) {
                            // set it to dual dialog
                            $previous_character->dual_dialog = true;
                        }
                    }

                    // add a character element
                    $line = (new DualDialogue())->sanitize($line);
                    $character = (new Character())->create($line);
                    $character->dual_dialog = $dual_dialog;
                    $this->elements()->addElement($character);

                    // Check if the Character contains inline parenthesis
                    if (preg_match('/\\(.*\\)/', $line, $matches)) {
                        $parenthesis = (new Parenthetical())->create($matches[0]);
                        $this->elements()->addElement($parenthesis);
                    }

                    continue;                   // no further processing needed
                }
            }

            /**
             * -----------------------------------------------------
             * Dialogue (and Parenthetical)
             * -----------------------------------------------------.
             */

            // assert if this is a parenthetical element
            $assertParenthetical = !$this->elements()->lastElementIsNewline() && (new Parenthetical())->match($line);

            // handle parenthesis elements
            if ($assertParenthetical) {
                // add a parenthetical element
                $parenthesis = (new Parenthetical())->create($line);
                $this->elements()->addElement($parenthesis);

                continue;
            }

            // if there were no newline before, and this isn't our first element
            if (!$this->elements()->lastElementIsNewline()) {
                /**
                 * If there are no newlines before
                 * determine if the current element matches the previous element,
                 * then append onto the previous instead of creating a new one.
                 * This allows us to create blocks of text under one parent tag.
                 */

                // find the previous element ('&' as reference)
                $last_element = $this->elements()->last();
                if (!$last_element) {
                    continue;
                }
                switch ($last_element->getType()) {
                    case Lyrics::class:

                        // lyrics should not be separated into paragraphs
                        // add this line to the previous element with a single line break
                        $lyric = (new Lyrics())->sanitize($line);
                        $last_element->appendText(PHP_EOL.$lyric);

                        break;
                    case TextCenter::class:

                        $text = (new TextCenter())->sanitize($line);
                        $last_element->appendText(PHP_EOL.$text);

                        break;
                    case Synopsis::class:

                        $text = (new Synopsis())->sanitize($line);
                        $last_element->appendText(PHP_EOL.PHP_EOL.$text);

                        break;
                    case Parenthetical::class:
                    case Character::class:

                        $dialogue = (new Dialogue())->create($line);
                        $this->elements()->addElement($dialogue);

                        break;
                    case Dialogue::class:

                        $last_element->appendText(PHP_EOL.$line);

                        break;
                    default:

                        // add this line to the previous element
                        // using a double newline for a line break in markdown
                        $last_element->appendText(PHP_EOL.PHP_EOL.$line);
                }

                continue;                   // no further processing needed
            }

            // If there are newlines previously
            if ($this->elements()->lastElementIsNewline()) {
                // return action as the default element
                $action = (new Action())->create($line);
                $this->elements()->addElement($action);

                continue;                   // no further processing needed
            }
        }

        return $this->elements();
    }

    /**
     * Elements.
     */
    public function elements(): FountainElementIterator
    {
        return $this->_elements;
    }

}
