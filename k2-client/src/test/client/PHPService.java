package test.client;

import java.util.Date;
import java.util.Set;

import com.google.gwt.core.client.GWT;
import com.google.gwt.http.client.Request;
import com.google.gwt.http.client.RequestBuilder;
import com.google.gwt.http.client.RequestCallback;
import com.google.gwt.http.client.RequestException;
import com.google.gwt.http.client.Response;
import com.google.gwt.http.client.URL;
import com.google.gwt.json.client.JSONObject;
import com.google.gwt.json.client.JSONParser;
import com.google.gwt.json.client.JSONValue;
import com.google.gwt.user.client.Window;
import com.gwtent.client.reflection.ClassType;
import com.gwtent.client.reflection.TypeOracle;

public class PHPService {
	
	public static String PHP_URL_SERVICE = "http://localhost/k2/index.php/mainservice/handler";
	public static String JAVA_SERVER_PROXY = "http://localhost:8888/CrossSiteRequestProxy";
	
	protected String serviceName ;
	protected String serviceMethod ;
	protected String jsonParams ;
	protected String serviceId;
	protected RequestCallback requestCallback;
	
	public String getServiceName() {
		return serviceName;
	}
	public void setServiceName(String serviceName) {
		this.serviceName = serviceName;
	}
	public String getServiceMethod() {
		return serviceMethod;
	}
	public void setServiceMethod(String serviceMethod) {
		this.serviceMethod = serviceMethod;
	}
	public String getJsonParams() {
		return jsonParams;
	}
	public void setJsonParams(String jsonParams) {
		this.jsonParams = jsonParams;
	}
	public String getServiceId() {
		return serviceId;
	}
	public RequestCallback getRequestCallback() {
		if(requestCallback == null){
			requestCallback = DEFAULT_REQUEST_CALLBACK;
		}
		return requestCallback;
	}
	public void setRequestCallback(RequestCallback requestCallback) {
		this.requestCallback = requestCallback;
	}
	
	public void sendResquest(RequestCallback callback){
		this.requestCallback = callback;
		sendResquest();
	}
	
	public void sendResquest(){
		this.serviceId = (new Date()).getTime()+"";
		
		String url = PHP_URL_SERVICE;
		if(JAVA_SERVER_PROXY.contains(GWT.getHostPageBaseURL())){
			url = JAVA_SERVER_PROXY;
		}
		
		StringBuilder data = new StringBuilder();
		data.append("service_name=").append(serviceName).append("&");
		data.append("service_method=").append(serviceMethod).append("&");
		data.append("service_method_params=").append(jsonParams).append("&");
		data.append("service_id=").append(serviceId);
		
		if(url.equals(JAVA_SERVER_PROXY)) {
			data.append("&").append("json_service_handler=").append(PHP_URL_SERVICE);
		}
		
		RequestBuilder builder = new RequestBuilder(RequestBuilder.POST, URL.encode(url+"?"+data));
		builder.setHeader("Content-Type", "application/x-www-form-urlencoded");
		
		System.out.println(data);
		
		builder.setRequestData(data.toString());
		builder.setCallback(getRequestCallback());

		try {			
			builder.send();
		} catch (RequestException e) {
			// Couldn't connect to server
		}
	}
	
	/**
	 * TODO improve performance
	 */
	private static final RequestCallback DEFAULT_REQUEST_CALLBACK = new RequestCallback() {
		public void onError(Request request,Throwable exception) {
			// Couldn't connect to server (could be
			// timeout, SOP violation, etc.)
			Window.alert(exception.getMessage());			
			exception.printStackTrace();
		}

		@Override
		public void onResponseReceived(Request request,	Response response) {
			if (200 == response.getStatusCode()) {
				try {				
					
					JSONValue jsonObj = JSONParser.parse(response.getText());
					String answer = jsonObj.isObject().get("answer").isString().stringValue();
					Window.alert(answer);
					JSONObject jsonObject = JSONParser.parse(answer).isObject();					
					
					String className = jsonObject.get("gwt_class").isString().stringValue();				
					ClassType classType = TypeOracle.Instance.getClassType(className);
					
					Friend friend = new Friend();//TODO make class by Generics
					
					Set<String> keys = jsonObject.keySet();
					for (String k : keys) {
						if(!k.equals("gwt_class")){							
							StringBuilder setter = new StringBuilder(3);
							setter.append("set");
							setter.append(k.charAt(0));
							setter.append(k.substring(1));							
							classType.invoke(friend, setter.toString() ,  new Object[]{jsonObject.get(k).isString().stringValue()});
						}
					}	
					
					// Process the response in
					// response.getText()
					Window.alert(friend.getName()+" | "+ friend.getBirthday()+" | "+friend.getPhoneNumber());
					
					
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
					Window.alert(e.getMessage());
				}
				
				
			} else {
				// Handle the error. Can get the status
				// text from response.getStatusText()
			}
		}
	};	

}

