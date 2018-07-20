<?php
/**
 * Admin quiz editor: paragraph question answer template.
 *
 * @since 3.0.0
 */

?>

<script type="text/x-template" id="tmpl-lp-quiz-paragraph-question-answer">
    <div class="admin-quiz-paragraph-question-editor">
        <ul class="paragraph-settings" style="text-align:left">
            <li class="paragraph-option">
                <label>
                    <b>
                    <?php _e( 'Error Message:', 'learnpress-paragraph' ); ?>
                    </b>
                </label><br>
                    <input type="text" id="placeholder" v-model="extra_settings.placeholder" @blur="updateAnswer" class="paragraph-input">

                <p class="description"><?php _e( 'Message to user when no answer is entered.', 'learnpress-paragraph' ); ?></p>
            </li>
            <li class="paragraph-option">
                <label>
                    <b>
                    <?php _e( 'Textarea Height:', 'learnpress-paragraph' ); ?>
                    </b>
                </label><br>
                    <input type="text" id="height" v-model="extra_settings.height" @blur="updateAnswer" class="paragraph-input">

                <p class="description"><?php _e( 'Examples: 100px or 20vh. Must include a px, vh, or em suffix.', 'learnpress-paragraph' ); ?></p>
            </li>
        </ul>
    </div>
</script>

<script type="text/javascript">

    function isJSON(str) {
        try {
            return (JSON.parse(str) && !!str);
        } catch (e) {
            return false;
        }
    }

    (function (Vue, $store, $) {
        var init = function() {

            console.log('init');
            console.log(this.question);

        }
        Vue.component('lp-quiz-paragraph-question-answer', {
            template: '#tmpl-lp-quiz-paragraph-question-answer',
            props: ['question'],
            data: function () {
                return {extra_settings: []}
            },
            computed: {
                answer: function () {
                    return {
                        answer_order: 1,
                        is_true: '',
                        question_answer_id: String(this.question.answers[0].question_answer_id),
                        text: this.question.answers[0].text,
                        value: ''
                    };
                }
            },
            methods: {
                updateAnswer: function () {
                    var answer = JSON.parse(JSON.stringify(this.answer));
                    var options = this.getOptions();
                    answer.text = JSON.stringify(options);
                    answer.extra_settings = options;

                    $store.dispatch('lqs/updateQuestionAnswerTitle', {
                        question_id: this.question.id,
                        answer: answer
                    });
                },
                getOptions: function() {
                    var extra_settings = {}
                    var search = '[data-item-id="'+this.question.id+'"]';
                    jQuery( search + ' .paragraph-option .paragraph-input').each(function() {
                        var id = jQuery(this).attr('id');
                        var value = jQuery(this).val();
                        extra_settings[id] = value;
                    });

                    console.log('extra_settings');
                    console.log(extra_settings);

                    return extra_settings;
                },
                defaultOptions: function() {

                    /* load extra_settings if exists */
                    var json = this.question.answers[0].text;
                    if (isJSON(json)) {
                        var extra_settings = JSON.parse(json);
                        this.extra_settings = extra_settings;
                    } else {
                        this.extra_settings = {};
                        this.extra_settings.placeholder = "This field is required..."
                        this.extra_settings.height = "100px"
                    }

                },
            },
            created: function () {
                init.apply(this);
                this.defaultOptions();
                /* update on load in case this is the very first load */
                setTimeout(function( e ) {
                    e.updateAnswer();
                } , 1000, this )
            }

        })
    })(Vue, LP_Quiz_Store, jQuery);

</script>
