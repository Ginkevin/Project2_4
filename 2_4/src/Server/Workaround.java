package Server;
import org.json.*;

public class Workaround implements Runnable{
	String result = "default";
	String [] result_array =  new String[10];
	boolean array = false;
	
	public Workaround(){
	
	}
	
	public void setResult(String res){
		this.result = res;
	}
	
	public void setResultArray(String[] array){
		this.result_array = array;
	}
	
	public String getResult(){
		return this.result;
	}
	
	public JSONObject getResultArray(){
		this.array = false;
		JSONObject obj = new JSONObject();
		try {
			for(int i=0; i<10; i++){
				String message = "message" +i;
				if(result_array[i]!=null){
					if (result_array[i].contains(">")){
						System.out.println("TRUE");
						result_array[i] = result_array[i].replace(">", "");
						System.out.println("result: " + result_array[i]);
					}
					obj.put(message, result_array[i]);
				}
			}
		} catch (JSONException e) {	e.printStackTrace();}	
		return obj;
	}
	
	public void setArray(){
		this.array = true;
	}
	
	public boolean isArray(){
		if (this.array){
			return true;
		}
		else{
			return false;
		}
	}

	@Override
	public void run() {
		// TODO Auto-generated method stub
		
	}
}
