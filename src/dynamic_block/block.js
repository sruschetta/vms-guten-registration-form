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

registerBlockType( 'vms/block-vms-gluten-login-form', {

	title: 'VMS - Login Form',
	icon: 'shield',
	category: 'widgets',
	attributes: {
		login_placeholder: { type: 'string' },
		password_placeholder: { type: 'string' },
		submit_button_label: { type: 'string' },
    email_missing_error: { type: 'string' },
		email_invalid_error: { type: 'string' },
    password_missing_error: {type: 'string' },
	},
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
	        { placeholder: "Email placeholder", attr: "email_placeholder" },
	        { placeholder: "Password placeholder", attr: "password_placeholder" },
          { placeholder: "Submit button label", attr: "submit_button_label" }
	      ];

	      var errorAttr = [
	        { placeholder: "Email missing error", attr: "email_missing_error" },
	        { placeholder: "Email invalid format error", attr: "email_invalid_error" },
	        { placeholder: "Password missing placeholder", attr: "password_missing_error" },
	      ];

	      return (
	        <div class="vms-registration-form">
	          <h3><b>VMS- Login form</b></h3>
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


  /*class extends Component {

		  constructor(props) {
		      super(...arguments);
		      this.props = props;
			}

		  render() {
		      return (
						<form class="vms_registration_form" asd="asdasdasd">
							<div class="vms_form_field">
								<input type="email" name="email" placeholder={this.props.attributes.email_placeholder} />
							</div>
							<div class="vms_form_field">
								<input type="text" name="password" placeholder={this.props.attributes.password_placeholder}/>
							</div>
							<input type="submit" value={this.props.attributes.submit_button_label}/>
						</form>
		     );
		  }
		},*/
} );
