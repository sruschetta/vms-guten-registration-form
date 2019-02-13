/**
 * BLOCK: vms-gluten-registration-form
 *
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { registerBlockType } = wp.blocks;
const { Component } = wp.element;
const { getCurrentPostId } = wp.data.select("core/editor");

registerBlockType( 'vms/vms-plugin-registration-form', {

	title: 'VMS - Registration Form',
	icon: 'shield',
	category: 'widgets',
	edit: class extends Component {

		constructor(props) {
	      super(...arguments);
	      this.props = props;
	  }

	  handleChange = name => event => {
	    var value = event.target.value;
	    this.props.setAttributes({ [name]: value });
	  }

	  render() {
	      const { className } = this.props;
	      var fieldsAttr = [
	        { placeholder: "First name placeholder", attr: "firstname_placeholder" },
	        { placeholder: "Last name placeholder", attr: "lastname_placeholder" },
	        { placeholder: "Email placeholder", attr: "email_placeholder" },
	        { placeholder: "Password placeholder", attr: "password_placeholder" },
	        { placeholder: "Confirm password placeholder", attr: "password2_placeholder" },
	        { placeholder: "Nation placeholder", attr: "nation_placeholder" },
	        { placeholder: "Age placeholder", attr: "age_placeholder" },
	        { placeholder: "Submit button label", attr: "submit_button_label" }
	      ];

	      var errorAttr = [
	        { placeholder: "First name missing error", attr: "firstname_error" },
	        { placeholder: "Last name missing error", attr: "lastname_error" },
	        { placeholder: "Email missing error", attr: "email_missing_error" },
	        { placeholder: "Email invalid format error", attr: "email_invalid_error" },
	        { placeholder: "Password missing placeholder", attr: "password_missing_error" },
	        { placeholder: "Password format error", attr: "password_format_error" },
	        { placeholder: "Password match error", attr: "password_match_error" },
	        { placeholder: "Nation missing error", attr: "nation_error" },
	        { placeholder: "Age missing error", attr: "age_error" }
	      ];

	      return (
	        <div class="vms-registration-form">
	          <h3><b>VMS- Registration form</b></h3>
	          <div>Placeholders</div>
	          {
	            fieldsAttr.map( (item, index) => {
	              return (
	                <input type="text"
	                       placeholder={ item.placeholder }
	                       onChange={ this.handleChange(item.attr) }
	                       value={ this.props.attributes[item.attr] } />
	              )
	            })
	          }
	          <hr/>
	          <div>Error messages</div>
	          {
	            errorAttr.map( (item, index) => {
	              return (
	                <input type="text"
	                       placeholder={ item.placeholder }
	                       onChange={ this.handleChange(item.attr) }
	                       value={ this.props.attributes[item.attr] } />
	              )
	            })
	          }
	        </div>
	      );
	  }
	},
	save: function(){
	  return null;
	}
} );
