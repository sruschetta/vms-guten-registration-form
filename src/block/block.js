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

registerBlockType( 'vms/block-vms-gluten-registration-form', {

	title: 'VMS - Registration Form',
	icon: 'shield',
	category: 'widgets',
	attributes: {
		firstname_placeholder: {
			type: 'string' ,
			default: 'Nome'
		},
		lastname_placeholder: { type: 'string' },
		email_placeholder: { type: 'string' },
		password_placeholder: { type: 'string' },
		password2_placeholder: { type: 'string' },
		nation_placeholder: { type: 'string' },
		age_placeholder: { type: 'string' },
		submit_button_label: { type: 'string' },
		firstname_error: { type: 'string' },
		lastname_error: { type: 'string' },
		email_missing_error: { type: 'string' },
		email_invalid_error: { type: 'string' },
		password_missing_error: {type: 'string' },
		password_format_error: {type: 'string' },
		password_match_error: {type:'string'},
		nation_error: { type: 'string' },
		age_error: { type: 'string' },
	},
	edit: class extends Component {

		constructor(props) {
	      super(...arguments);
	      this.props = props;
				console.log(getCurrentPostId());
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
	save: class extends Component {

		  constructor(props) {
		      super(...arguments);
		      this.props = props;
			}

		  render() {
		      return (
						<form class="vms_registration_form" asd="asdasdasd">
							<div class="vms_form_field">
								{this.props.attributes.firstname_placeholder}
								<input type="text" name="firstname" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">
								{this.props.attributes.lastname_placeholder}
								<input type="text" name="lastname" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">
								{this.props.attributes.email_placeholder}
								<input type="email" name="email" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">
								{this.props.attributes.password_placeholder}
								<input type="text" name="password" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">
								{this.props.attributes.password2_placeholder}
								<input type="text" name="password2" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">
								{this.props.attributes.nation_placeholder}
								<input type="text" name="nation" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">
								{this.props.attributes.age_placeholder}
								<input type="number" name="age" />
								<span class="vms_form_error"></span>
							</div>
							<input type="submit" value={this.props.attributes.submit_button_label}/>
						</form>
		     );
		  }
		},
} );
