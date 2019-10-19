<?php

 class QuestionTypes {
    const TEXT = 0;
    const CHECK = 1;
    const DROP = 2;
    const SLIDER = 3;
}

abstract class Question {
    protected $type;
    protected $content;
    protected $multiple;
    protected $required;

    /**
     * @return string The content of the question.
     */
    public function getContent(): string { return $this->content; }
    /**
     * @return int The type of the question as a constant from the QuestionTypes class.
     */
    public function getType(): int { return $this->type; }
    /**
     * @return bool Whether this question allows multiple lines/selections.
     */
    public function allowMultiple(): bool { return $this->multiple; }
    /**
     * @return bool Whether this question is required.
     */
    public function isRequired(): bool { return $this->required; }

    /**
     * @param string $content The question itself.
     * @param bool $multiple Whether this question allows multiple lines/selections.
     * @param bool $required Whether this question is required.
     */
    protected function __construct(string $content, bool $multiple, bool $required) {
        $this->content = $content;
        $this->multiple = $multiple;
        $this->required = $required;
    }

    /**
     * @return string The question as HTML.
     */
    abstract function toHTML($id): string;
}

class QText extends Question {
    private $placeholder;

    function __construct(string $content, string $placeholder = "", bool $multiline = false, bool $required = true) {
        $this->type = QuestionTypes::TEXT;
        parent::__construct($content, $multiline, $required);
        $this->placeholder = $placeholder;
    }

    public function getPlaceholder(): string { return $this->placeholder; }

    public function toHTML($id): string {
        return "<div class='form-group'>"
             . "    <label for='question-$id'>$this->content</label>"
             . (($this->multiple == true)
             ? "    <textarea class='form-control' id='question-$id' rows='3' name='question-$id' placeholder='$this->placeholder'></textarea>"
             : "    <input type='text' class='form-control' id='question-$id' name='question-$id' placeholder='$this->placeholder'>")
             . "</div>";
    }
}

class QCheck extends Question {
    private $choices;

    /**
     * @param string $content The question itself.
     * @param array $choices An array of choices for each checkbox.
     * @param bool $radio Whether to use radio buttons instead of checkboxes.
     */
    function __construct(string $content, array $choices, bool $radio = false, bool $required = true) {
        $this->type = QuestionTypes::CHECK;
        parent::__construct($content, !$radio, $required);
        $this->choices = $choices;
    }

    public function getChoices(): array { return $this->choices; }

    public function toHTML($id): string {
        $html = "<div class='form-group'>"
              . "    <label>$this->content</label>";
        $i = 0;
        foreach ($this->choices as $choice) {
            $html .= "<div class='form-check'>"
                   . "    <input class='form-check-input' type='" . ($this->multiple ? "checkbox" : "radio") . "' id='question-$id-$i' name='question-$id" . ($this->multiple ? "-$i" : "") . "' value='" . strtolower(trim(str_replace(" ", "_", $choice))) . "'>"
                   . "    <label class='form-check-label' for='question-$id-$i'>$choice</label>"
                   . "</div>";
            $i++;
        }
        $html .= "</div>";
        return $html;
    }
}

class QDrop extends Question {
    private $choices;

    /**
     * @param string $content The question itself.
     * @param array $choices An array of choices for the dropdown.
     * @param bool $multiple Whether to allow multiple selections.
     */
    function __construct(string $content, array $choices, bool $multiple = false, bool $required = true) {
        $this->type = QuestionTypes::DROP;
        parent::__construct($content, $multiple, $required);
        $this->choices = $choices;
    }

    public function getChoices(): array { return $this->choices; }

    public function toHTML($id): string {
        $html  = "<div class='form-group'>"
               . "    <label for='question-$id'>$this->content</label>"
               . "    <select class='form-control' id='question-$id' name='question-$id'" . ($this->multiple ? " multiple" : "") . ">";
        foreach ($this->choices as $choice) {
            $html .= "<option value='" . strtolower(trim(str_replace(" ", "_", $choice))) . "'>$choice</option>";
        }
        $html .= "    </select>"
               . "</div>";
        return $html;
    }
}

class QSlider extends Question {
    private $start;
    private $end;
    private $interval;

    function __construct(string $content, float $start, float $end, float $interval, bool $required = true) {
        $this->type = QuestionTypes::SLIDER;
        parent::__construct($content, false, $required);
        $this->start = $start;
        $this->end = $end;
        $this->interval = $interval;
    }

    public function getStart(): float { return $this->start; }
    public function getEnd(): float { return $this->end; }
    public function getInterval(): float { return $this->interval; }

    public function toHTML($id): string {
        $default = $this->start + $this->interval;
        return "<div class='form-group'>"
             . "    <label for='question-$id'>$this->content</label>"
             . "    <input type='range' class='form-control-range' id='question-$id' name='question-$id' min='$this->start' max='$this->end' step='$this->interval' value='$default'>"
             . "</div>";
    }
}

?>