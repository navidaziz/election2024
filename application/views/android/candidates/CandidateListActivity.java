
public class CandidateListActivity extends AppCompatActivity {
	
	static String[][] Items;
    private GoogleApiClient client;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_list_candidate);
		
		RequestQueue request_queue = Volley.newRequestQueue(CandidateListActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/candidate/view", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								 Items = new String[JsonArray.length()][4];
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									Items[i][0] = json_object.getString("name");
				Items[i][1] = json_object.getString("political_party");
				Items[i][2] = json_object.getString("symbol");
				Items[i][3] = json_object.getString("image");
				
			
								}
								
								CandidateAdapter candidateAdapter;
                    			candidateAdapter = new CandidateAdapter(CandidateListActivity.this,Items);
                    			candidate_listView.setAdapter(candidateAdapter);
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							    Toast.makeText(CandidateListActivity, "Error in Json", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(CandidateListActivity, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);
		
		
		
 candidate_listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent i = new Intent(CandidateListActivity.this, CandidateView.class);
                i.putExtra("candidate_id", Items[position][0]);
                startActivity(i);
            }
        });
		
		

        
    }

}
