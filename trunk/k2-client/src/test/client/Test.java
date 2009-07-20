package test.client;

import java.util.Date;

import com.google.gwt.core.client.EntryPoint;
import com.google.gwt.core.client.GWT;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.dom.client.ClickHandler;
import com.google.gwt.event.logical.shared.ValueChangeEvent;
import com.google.gwt.event.logical.shared.ValueChangeHandler;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.AbsolutePanel;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.FormPanel;
import com.google.gwt.user.client.ui.Hidden;
import com.google.gwt.user.client.ui.RootPanel;
import com.google.gwt.user.client.ui.TextArea;
import com.google.gwt.user.client.ui.TextBox;
import com.google.gwt.user.datepicker.client.DatePicker;

/**
 * Entry point classes define <code>onModuleLoad()</code>.
 */
public class Test implements EntryPoint {
	private Button clickMeButton = new Button();
	private final TextBox txtbxHelloword = new TextBox();
	private final TextBox txtbxCallwithparam = new TextBox();
	private final DatePicker datePicker = new DatePicker();
	private final FormPanel formPanel = new FormPanel();
	private final AbsolutePanel absolutePanel = new AbsolutePanel();
	private final TextArea txtService_method_params = new TextArea();
	private final Hidden service_id = new Hidden("service_id");
	private final Hidden json_service_handler = new Hidden("json_service_handler");
	
	public static final String LOCAL_PROXY = "http://localhost:8888/CrossSiteRequestProxy";
	
	
	public void initForm(){
		formPanel.setAction(LOCAL_PROXY);
	}
	
	public void onModuleLoad() {
		RootPanel rootPanel = RootPanel.get();			
				
		absolutePanel.add(clickMeButton, 202, 275);
		clickMeButton.setText("Test this!");
		this.formPanel.setAction("http://localhost:8888/CrossSiteRequestProxy");
		this.formPanel.setMethod(FormPanel.METHOD_POST);

		formPanel.add(absolutePanel);
		absolutePanel.setSize("100%", "100%");
		rootPanel.add(formPanel, 5, 5);
		formPanel.setSize("100%", "100%");
		txtbxHelloword.setName("service_name");
		
		absolutePanel.add(txtbxHelloword, 165, 25);		

		this.txtbxHelloword.setText("HelloWord");
		txtbxCallwithparam.setName("service_method");
		absolutePanel.add(txtbxCallwithparam, 165, 75);		

		this.txtbxCallwithparam.setText("getFriend");
		absolutePanel.add(datePicker, 490, 25);
		
		txtService_method_params.setName("service_method_params");
		txtService_method_params.setText("{\"0\": 1001}");
		absolutePanel.add(txtService_method_params, 31, 129);
		txtService_method_params.setSize("410px", "61px");
	
		
		absolutePanel.add(json_service_handler);
		absolutePanel.add(service_id);
	
		
		
		this.datePicker.addValueChangeHandler(new DatePickerValueChangeHandler());

		clickMeButton.addClickHandler(new ClickHandler() {
			@Override
			public void onClick(ClickEvent event) {
				
				PHPService service =  GWT.create(PHPService.class);
				service.setServiceName(txtbxHelloword.getText());
				service.setServiceMethod(txtbxCallwithparam.getText());
				service.setJsonParams(txtService_method_params.getText());				
				service.sendResquest();				
			}
		});
	}



	private class DatePickerValueChangeHandler implements ValueChangeHandler {
		@Override
		public void onValueChange(ValueChangeEvent event) {
			Date date = (Date) event.getValue();
			Window.alert(date.toString());

		}
	}
}
