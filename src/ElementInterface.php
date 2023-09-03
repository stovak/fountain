<?php

namespace Fountain;

/**
 *
 */
interface ElementInterface
{
    /**
     * @param string $line
     * @param ElementInterface|null $previousElement
     * @return bool
     */
    public function match(string $line, ?ElementInterface &$previousElement = null): bool;

    /**
     * @param string $line
     * @return string
     */
    public function sanitize(string $line): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @param string $text
     * @return void
     */
    public function setText(string $text): void;

    /**
     * @param string $text
     * @return void
     */
    public function appendText(string $text): void;

    /**
     * @param string $type
     * @return bool
     */
    public function is(string $type): bool;

    /**
     * @param string $text
     * @return ElementInterface
     */
    public function create(string $text): ElementInterface;

    /**
     * @return string
     */
    public function __toString(): string;
}
