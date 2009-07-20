package test.server;

import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.ServletRequest;
import javax.servlet.ServletResponse;
import javax.servlet.http.HttpServlet;

import org.apache.commons.httpclient.HttpClient;
import org.apache.commons.httpclient.methods.PostMethod;


public class CrossSiteRequestImpl extends HttpServlet {

	@Override
	public void service(ServletRequest req, ServletResponse res)
			throws ServletException, IOException {

		String service_name = req.getParameter("service_name");
		String service_method = req.getParameter("service_method");
		String service_method_params = req.getParameter("service_method_params");
		String service_id = req.getParameter("service_id");
		String json_service_handler = req.getParameter("json_service_handler");

		System.out.println(service_name);
		System.out.println(service_method);
		System.out.println(service_method_params);
		System.out.println(service_id);
		System.out.println(json_service_handler);

		PostMethod post = new PostMethod(json_service_handler);
		post.addParameter("service_name", service_name);
		post.addParameter("service_method", service_method);
		post.addParameter("service_method_params", service_method_params);
		post.addParameter("service_id", service_id);
		
				
		HttpClient client = new HttpClient();
		client.executeMethod(post);
		String result = post.getResponseBodyAsString();
		post.releaseConnection();

		System.out.println("result: "+result);
		
		res.getWriter().print(result);
		res.flushBuffer();
	}
}
