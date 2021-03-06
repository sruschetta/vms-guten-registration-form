/**
 * BLOCK: vms-gluten-registration-form
 *
 */

//  Import CSS.
import '../style/style.scss';
import '../style/editor.scss';

const { registerBlockType } = wp.blocks;
const { Component } = wp.element;
const { getCurrentPostId } = wp.data.select("core/editor");
const { TextControl } = wp.components;
const RichText = wp.editor.RichText;

registerBlockType( 'vms/vms-plugin-registration-form', {

	title: 'VMS - Registration Form',
	icon: 'welcome-write-blog',
	category: 'widgets',
	edit: class extends Component {

		constructor(props) {
	      super(...arguments);
	      this.props = props;
	  }

	  handleChange = name => value => {
	    this.props.setAttributes({ [name]: value });
	  }

		handleSelectChange = name => event => {
		 var value = event.target.value;
		 this.props.setAttributes({ [name]: value });
	 }


	  render() {
	      const { className } = this.props;
				const {pages} = this.props.attributes;
				const selected = this.props.attributes.target_page;

	      var fieldsAttr = [
	        { placeholder: "First name placeholder", attr: "firstname_placeholder" },
	        { placeholder: "Last name placeholder", attr: "lastname_placeholder" },
	        { placeholder: "Email placeholder", attr: "email_placeholder" },
					{ placeholder: "Email Confirm placeholder", attr: "email2_placeholder" },
	        { placeholder: "Password placeholder", attr: "password_placeholder" },
	        { placeholder: "Confirm password placeholder", attr: "password2_placeholder" },
	        { placeholder: "Nation placeholder", attr: "nation_placeholder" },
	        { placeholder: "Birthdate placeholder", attr: "birthdate_placeholder" },
					{ placeholder: "Day placeholder", attr: "day_placeholder" },
					{ placeholder: "Month placeholder", attr: "month_placeholder" },
					{ placeholder: "Year placeholder", attr: "year_placeholder" },
	        { placeholder: "Submit button label", attr: "submit_button_label" }
	      ];

	      var errorAttr = [
	        { placeholder: "First name missing error", attr: "first_name_missing_error" },
	        { placeholder: "Last name missing error", attr: "last_name_missing_error" },
	        { placeholder: "Email missing error", attr: "email_missing_error" },
	        { placeholder: "Email invalid format error", attr: "email_invalid_error" },
					{ placeholder: "Email match error", attr: "email_match_error" },
	        { placeholder: "Password missing placeholder", attr: "password_missing_error" },
	        { placeholder: "Password format error", attr: "password_format_error" },
	        { placeholder: "Password match error", attr: "password_match_error" },
	        { placeholder: "Nation missing error", attr: "nation_missing_error" },
	        { placeholder: "Birthdate missing error", attr: "birthdate_missing_error" },
					{ placeholder: "Invalid date error", attr: "invalid_date_error" },
					{ placeholder: "Privacy error", attr: "privacy_error" }
	      ];

	      return (
	        <div class="vms-form">

	          <h3><b>VMS- Registration form</b></h3>
	          <div>Placeholders</div>
	          {
	            fieldsAttr.map( (item, index) => {
	              return (
	                <TextControl placeholder={ item.placeholder }
				                       onChange={ this.handleChange(item.attr) }
				                       value={ this.props.attributes[item.attr] } />
	              )
	            })
	          }
	          <hr/>
	          <div>Privacy text</div>
						<RichText onChange={ this.handleChange('privacy_text') }
											value={ this.props.attributes['privacy_text'] }/>
						<hr/>
					 <div>Error messages</div>
	          {
	            errorAttr.map( (item, index) => {
	              return (
	                <TextControl placeholder={ item.placeholder }
				                       onChange={ this.handleChange(item.attr) }
				                       value={ this.props.attributes[item.attr] } />
	              )
	            })
	          }
						<hr/>
						<div>Successful creation message</div>
							<RichText onChange={ this.handleChange('user_creation_successful_message') }
												value={ this.props.attributes['user_creation_successful_message'] }/>
						<hr/>
						<div>Redirect page</div>
						<select onChange={ this.handleSelectChange('target_page') }>
							{
								pages.map( (item, index) => {

									var id = item.ID;
									var post_name = item.post_name;
									post_name = post_name.charAt(0).toUpperCase() + post_name.slice(1);

									if(selected == id) {
										return (
											<option value={id} selected="selected">{post_name}</option>
										);
									}
									else {
										return (
											<option value={id}>{post_name}</option>
										);
									}
								})
							}
						</select>
						<hr/>
						<div>Registration email settings</div>
						<TextControl placeholder={ "Registration email subject" }
												 onChange={ this.handleChange('registration_email_subject') }
												 value={ this.props.attributes['registration_email_subject'] }/>
						<RichText placeholder={ "Registration email text" }
											onChange={ this.handleChange('registration_email_text') }
											value={ this.props.attributes['registration_email_text'] }/>
	        </div>
	      );
	  }
	},
	save: function(){
	  return null;
	}
} );
