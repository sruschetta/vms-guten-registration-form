/**
 * BLOCK: vms-login-form
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

registerBlockType( 'vms/vms-plugin-login-form', {

	title: 'VMS - Login Form',
	icon: 'admin-users',
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
	        { placeholder: "Email placeholder", attr: "email_placeholder" },
	        { placeholder: "Password placeholder", attr: "password_placeholder" },
	        { placeholder: "Submit button label", attr: "submit_button_label" }
	      ];

	      var errorAttr = [
	        { placeholder: "Email missing error", attr: "email_missing_error" },
	        { placeholder: "Email invalid format error", attr: "email_invalid_error" },
	        { placeholder: "Password missing error", attr: "password_missing_error" },
	      ];
	      return (
	        <div class="vms-form">
	          <h3><b>VMS - Login form</b></h3>
	          <div>Placeholders</div>
	          {
	            fieldsAttr.map( (item, index) => {
	              return (
	                <TextControl type="text"
	                       placeholder={ item.placeholder }
	                       onChange={ this.handleChange(item.attr) }
	                       value={ this.props.attributes[item.attr] } />
	              )
	            })
	          }
						<hr/>
						<div>Redirect page</div>
						<RichText type="text"
											placeholder={ "Footer text" }
											onChange={ this.handleChange("footer_text") }
											value={ this.props.attributes["footer_text"] } />
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
	          <div>Error messages</div>
	          {
	            errorAttr.map( (item, index) => {
	              return (
	                <TextControl type="text"
	                       			 placeholder={ item.placeholder }
	                       			 onChange={ this.handleChange(item.attr) }
	                       			 value={ this.props.attributes[item.attr] } />
	              )
	            })
	          }

						<hr/>
						<div>Login error messages</div>
							<RichText placeholder={"User not found"}
											 	onChange={ this.handleChange('user_not_found_error') }
												value={ this.props.attributes['user_not_found_error'] }/>
					</div>
			);
	  }
	},
	save: function(){
	  return null;
	}
});
